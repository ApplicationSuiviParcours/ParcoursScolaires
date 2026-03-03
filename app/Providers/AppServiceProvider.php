<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Partage des données avec toutes les vues
        View::composer('*', function ($view) {
            // Valeurs par défaut
            $userRole = 'Visiteur';
            $notificationCount = 0;
            $notifications = collect([]);
            $unreadNotifications = collect([]);

            if (auth()->check()) {
                /** @var \App\Models\User $user */
                $user = auth()->user();

                try {
                    // Récupérer le libellé du rôle principal
                    $userRole = $this->getUserPrimaryRole($user);

                    // Récupérer les notifications si la relation existe
                    if (method_exists($user, 'notifications')) {
                        $notifications = $user->notifications()->latest()->limit(5)->get();
                        $notificationCount = $user->unreadNotifications()->count();
                        $unreadNotifications = $user->unreadNotifications()->limit(5)->get();
                    }

                } catch (\Exception $e) {
                    // En cas d'erreur, on garde les valeurs par défaut
                    Log::warning('Erreur dans AppServiceProvider: ' . $e->getMessage());
                }
            }

            // Variables disponibles dans TOUTES les vues
            $view->with([
                'userRole' => $userRole,
                'notificationCount' => $notificationCount,
                'notifications' => $notifications,
                'unreadNotifications' => $unreadNotifications,
                'isAuthenticated' => auth()->check(),
                'currentUser' => auth()->user(),
            ]);
        });
    }

    /**
     * Récupère le libellé du rôle principal de l'utilisateur
     *
     * @param \App\Models\User $user
     * @return string
     */
    private function getUserPrimaryRole($user): string
    {
        // Méthode 1: Si vous avez la méthode getRoleLibelle()
        if (method_exists($user, 'getRoleLibelle')) {
            return $user->getRoleLibelle();
        }

        // Méthode 2: Utiliser Spatie Permission
        if (method_exists($user, 'roles') && $user->roles->isNotEmpty()) {
            // Priorité des rôles (ajustez selon vos besoins)
            $rolePriority = [
                'administrateur' => 1,
                'enseignant' => 2,
                'parent' => 3,
                'eleve' => 4,
            ];

            // Trier les rôles par priorité
            $roles = $user->roles->sortBy(function($role) use ($rolePriority) {
                return $rolePriority[$role->name] ?? 999;
            });

            return $roles->first()->libelle ?? $roles->first()->name ?? 'Utilisateur';
        }

        // Méthode 3: Détection par les relations de profil
        if ($user->eleve()->exists()) {
            return 'Élève';
        }

        if ($user->enseignant()->exists()) {
            return 'Enseignant';
        }

        if ($user->parentEleve()->exists()) {
            return 'Parent';
        }

        return 'Utilisateur';
    }
}
