<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Eleve;
use App\Models\Absence;
use App\Models\Bulletin;
use App\Models\EleveParent;
use App\Models\ParentEleve;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Envoyer une notification à un utilisateur spécifique
     */
    public function envoyer(User $user, array $data): ?Notification
    {
        try {
            return Notification::create([
                'user_id' => $user->id,
                'type'    => $data['type'] ?? 'info',
                'title'   => $data['title'],
                'message' => $data['message'],
                'icon'    => $data['icon'] ?? null,
                'link'    => $data['link'] ?? null,
                'read'    => false,
            ]);
        } catch (\Exception $e) {
            Log::error('NotificationService::envoyer - Erreur: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Envoyer une notification à plusieurs utilisateurs
     */
    public function envoyerAMultiple(iterable $users, array $data): int
    {
        $count = 0;
        foreach ($users as $user) {
            if ($user instanceof User && $user->id) {
                if ($this->envoyer($user, $data)) {
                    $count++;
                }
            }
        }
        return $count;
    }

    /**
     * Notifier les parents d'un élève lors d'une absence
     */
    public function notifierParentsDeAbsence(Absence $absence): int
    {
        $eleve = $absence->eleve;
        if (!$eleve) return 0;

        // Récupérer tous les parents de l'élève qui ont un compte utilisateur
        $parents = EleveParent::query()->where('eleve_id', $eleve->id)
            ->with(['parentEleve.user'])
            ->get();

        $count = 0;
        foreach ($parents as $eleveParent) {
            $parentEleve = $eleveParent->parentEleve ?? null;
            if (!$parentEleve || !$parentEleve->user) continue;

            $user = $parentEleve->user;
            $matiere = $absence->matiere->nom ?? 'une matière';
            $date = $absence->date_absence
                ? $absence->date_absence->format('d/m/Y')
                : now()->format('d/m/Y');

            $this->envoyer($user, [
                'type'    => 'warning',
                'title'   => '⚠️ Absence signalée',
                'message' => "Une absence de {$eleve->prenom} {$eleve->nom} a été enregistrée le {$date} en {$matiere}."
                           . ($absence->justifiee ? ' (Justifiée)' : ' (Non justifiée)'),
                'icon'    => 'warning',
                'link'    => route('parent.enfant.absences', $eleve->id),
            ]);
            $count++;
        }

        return $count;
    }

    /**
     * Notifier les parents lors de la génération d'un bulletin
     */
    public function notifierParentsDeBulletin(Bulletin $bulletin): int
    {
        $eleve = $bulletin->eleve;
        if (!$eleve) return 0;

        // Récupérer tous les parents de l'élève qui ont un compte utilisateur
        $parents = EleveParent::query()->where('eleve_id', $eleve->id)
            ->with(['parentEleve.user'])
            ->get();

        $count = 0;
        foreach ($parents as $eleveParent) {
            $parentEleve = $eleveParent->parentEleve ?? null;
            if (!$parentEleve || !$parentEleve->user) continue;

            $user = $parentEleve->user;
            $periode = $bulletin->periode ?? 'la période';
            $moyenne = number_format($bulletin->moyenne_generale ?? 0, 2);
            $mention = $bulletin->mention ?? '';

            $this->envoyer($user, [
                'type'    => 'success',
                'title'   => '📋 Nouveau bulletin disponible',
                'message' => "Le bulletin de {$eleve->prenom} {$eleve->nom} pour le {$periode} est disponible."
                           . " Moyenne : {$moyenne}/20 — {$mention}.",
                'icon'    => 'bulletin',
                'link'    => route('parent.enfant.bulletin', $eleve->id),
            ]);
            $count++;
        }

        return $count;
    }

    /**
     * Notifier tous les parents (broadcast de l'admin)
     */
    public function notifierTousParents(string $titre, string $message, string $type = 'info', ?string $lien = null): int
    {
        $users = User::role('parent')->where('is_active', true)->get();
        return $this->envoyerAMultiple($users, [
            'type'    => $type,
            'title'   => $titre,
            'message' => $message,
            'icon'    => 'info',
            'link'    => $lien,
        ]);
    }

    /**
     * Notifier tous les enseignants
     */
    public function notifierTousEnseignants(string $titre, string $message, string $type = 'info', ?string $lien = null): int
    {
        $users = User::role('enseignant')->where('is_active', true)->get();
        return $this->envoyerAMultiple($users, [
            'type'    => $type,
            'title'   => $titre,
            'message' => $message,
            'icon'    => 'info',
            'link'    => $lien,
        ]);
    }

    /**
     * Notifier tous les admins
     */
    public function notifierTousAdmins(string $titre, string $message, string $type = 'info', ?string $lien = null): int
    {
        $users = User::role('administrateur')->where('is_active', true)->get();
        return $this->envoyerAMultiple($users, [
            'type'    => $type,
            'title'   => $titre,
            'message' => $message,
            'icon'    => 'info',
            'link'    => $lien,
        ]);
    }

    /**
     * Notifier les parents d'une classe entière
     */
    public function notifierParentsDeClasse(int $classeId, string $titre, string $message, string $type = 'info', ?string $lien = null): int
    {
        // Récupérer les élèves de la classe
        $eleveIds = \App\Models\Inscription::query()->where('classe_id', $classeId)
            ->whereIn('statut', ['inscrit', 'active', '1', 1, true])
            ->pluck('eleve_id');

        // Récupérer les parents de ces élèves
        $parentIds = EleveParent::query()->whereIn('eleve_id', $eleveIds)
            ->with('parentEleve.user')
            ->get()
            ->map(fn($ep) => $ep->parentEleve?->user)
            ->filter()
            ->unique('id');

        return $this->envoyerAMultiple($parentIds, [
            'type'    => $type,
            'title'   => $titre,
            'message' => $message,
            'icon'    => 'info',
            'link'    => $lien,
        ]);
    }

    /**
     * Notifier un utilisateur spécifique par son ID
     */
    public function notifierUser(int $userId, array $data): ?Notification
    {
        $user = User::find($userId);
        if (!$user) return null;
        return $this->envoyer($user, $data);
    }
}
