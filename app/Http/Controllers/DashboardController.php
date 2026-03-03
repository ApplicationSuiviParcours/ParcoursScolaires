<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        // Log pour le débogage
        $roles = $user->roles->pluck('name')->implode(', ');
        Log::info('DashboardController - User: ' . $user->id . ', Roles: ' . $roles);

        // Vérifier le rôle et rediriger en conséquence
        // Utiliser les méthodes du modèle User qui utilisent Spatie
        if ($user->hasRole('administrateur')) {
            Log::info('Redirecting to admin.dashboard');
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('enseignant')) {
            Log::info('Redirecting to enseignant.dashboard');
            return redirect()->route('enseignant.dashboard');
        }

        if ($user->hasRole('eleve')) {
            Log::info('Redirecting to eleve.dashboard');
            return redirect()->route('eleve.dashboard');
        }

        if ($user->hasRole('parent')) {
            Log::info('Redirecting to parent.dashboard');
            return redirect()->route('parent.dashboard');
        }

        // Si aucun rôle n'est trouvé, afficher un message d'erreur
        // ou assigner un rôle par défaut et rediriger
        Log::warning('No role found for user: ' . $user->id);

        // Par défaut, rediriger vers la page d'accueil avec un message
        return redirect('/')->with('error', 'Votre compte n\'a pas de rôle assigné. Veuillez contacter l\'administration.');
    }
}
