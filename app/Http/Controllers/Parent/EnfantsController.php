<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Note;
use App\Models\Absence;
use App\Models\Bulletin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnfantsController extends Controller
{
    public function mesEnfants()
    {
        $user = Auth::user();
        
        if (!$user->isParent()) {
            abort(403, 'Accès non autorisé.');
        }

        // Récupérer le parent et ses enfants
        $parent = $user->parentEleve;
        
        if (!$parent) {
            return view('parent.enfants', [
                'enfants' => collect([]),
                'statsGlobales' => [
                    'total_notes' => 0,
                    'total_absences' => 0,
                    'total_bulletins' => 0,
                ]
            ]);
        }

        // Récupérer les enfants avec leurs relations en utilisant les accesseurs du modèle
        $enfants = $parent->eleves()
            ->with([
                'inscriptionActive.classe',
                'notes' => function($q) {
                    $q->with('evaluation.matiere')
                      ->latest()
                      ->limit(5);
                },
                'absences' => function($q) {
                    $q->with('matiere')
                      ->latest('date_absence')
                      ->limit(5);
                }
            ])
            ->get();

        // Statistiques globales
        $statsGlobales = [
            'total_notes' => 0,
            'total_absences' => 0,
            'total_bulletins' => 0,
        ];

        // Récupérer les IDs des enfants pour optimiser les requêtes
        $enfantIds = $enfants->pluck('id')->toArray();

        if (!empty($enfantIds)) {
            // Récupérer les statistiques en une seule requête pour optimiser
            $notesStats = Note::whereIn('eleve_id', $enfantIds)
                ->select('eleve_id', 
                    DB::raw('count(*) as count'),
                    DB::raw('avg(note) as moyenne')
                )
                ->groupBy('eleve_id')
                ->get()
                ->keyBy('eleve_id');

            $absencesStats = Absence::whereIn('eleve_id', $enfantIds)
                ->select('eleve_id', 
                    DB::raw('count(*) as count'),
                    DB::raw('SUM(CASE WHEN justifiee = 0 THEN 1 ELSE 0 END) as non_justifiees')
                )
                ->groupBy('eleve_id')
                ->get()
                ->keyBy('eleve_id');

            $bulletinsStats = Bulletin::whereIn('eleve_id', $enfantIds)
                ->select('eleve_id', DB::raw('count(*) as count'))
                ->groupBy('eleve_id')
                ->get()
                ->keyBy('eleve_id');

            // Ajouter les stats à chaque enfant
            foreach ($enfants as $enfant) {
                $notesStat = $notesStats[$enfant->id] ?? null;
                $absencesStat = $absencesStats[$enfant->id] ?? null;
                $bulletinsStat = $bulletinsStats[$enfant->id] ?? null;

                $notesCount = $notesStat->count ?? 0;
                $moyenneGenerale = $notesStat->moyenne ?? 0;
                $absencesCount = $absencesStat->count ?? 0;
                $absencesNonJustifiees = $absencesStat->non_justifiees ?? 0;
                $bulletinsCount = $bulletinsStat->count ?? 0;

                // Ajouter les stats à l'enfant
                $enfant->stats = [
                    'notes_count' => $notesCount,
                    'moyenne_generale' => round($moyenneGenerale, 2),
                    'absences_count' => $absencesCount,
                    'absences_non_justifiees' => $absencesNonJustifiees,
                    'bulletins_count' => $bulletinsCount,
                ];

                // Mettre à jour les stats globales
                $statsGlobales['total_notes'] += $notesCount;
                $statsGlobales['total_absences'] += $absencesCount;
                $statsGlobales['total_bulletins'] += $bulletinsCount;
            }
        }

        return view('parent.enfants', compact('enfants', 'statsGlobales'));
    }
}