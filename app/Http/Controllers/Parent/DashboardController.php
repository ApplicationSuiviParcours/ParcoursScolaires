<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Note;
use App\Models\Absence;
use App\Models\Bulletin;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->isParent()) {
            abort(403, 'Accès non autorisé.');
        }

        $parent = $user->parentEleve;
        
        if (!$parent) {
            return $this->vueVide();
        }

        $enfants = $parent->eleves()
            ->with(['classe'])
            ->get();

        if ($enfants->isEmpty()) {
            return $this->vueVide();
        }

        $stats = [
            'total_enfants' => $enfants->count(),
            'total_notes' => 0,
            'total_absences' => 0,
            'total_bulletins' => 0,
            'absences_non_justifiees' => 0,
        ];

        $donneesEnfants = [];

        foreach ($enfants as $enfant) {
            // Statistiques détaillées pour chaque enfant
            $notes = Note::where('eleve_id', $enfant->id)
                ->with(['evaluation.matiere'])
                ->latest()
                ->get();

            $absences = Absence::where('eleve_id', $enfant->id)
                ->with(['matiere'])
                ->latest('date_absence')
                ->get();

            $bulletins = Bulletin::where('eleve_id', $enfant->id)
                ->latest('date_bulletin')
                ->get();

            // Calculs
            $moyenneGenerale = $notes->avg('note') ?? 0;
            $absencesNonJustifiees = $absences->where('justifiee', false)->count();
            
            // Dernières notes (limité à 5)
            $dernieresNotes = $notes->take(5);
            
            // Dernières absences (limité à 5)
            $dernieresAbsences = $absences->take(5);

            // Dernier bulletin
            $dernierBulletin = $bulletins->first();

            // Statistiques par matière
            $statsParMatiere = [];
            foreach ($notes->groupBy('evaluation.matiere_id') as $matiereId => $notesMatiere) {
                $matiere = $notesMatiere->first()->evaluation->matiere ?? null;
                if ($matiere) {
                    $moyenneMatiere = $notesMatiere->avg('note');
                    $statsParMatiere[] = [
                        'nom' => $matiere->nom,
                        'moyenne' => round($moyenneMatiere, 2),
                        'couleur' => $moyenneMatiere >= 16 ? 'green' : 
                                   ($moyenneMatiere >= 14 ? 'blue' : 
                                   ($moyenneMatiere >= 10 ? 'yellow' : 'red'))
                    ];
                }
            }

            // Mettre à jour les stats globales
            $stats['total_notes'] += $notes->count();
            $stats['total_absences'] += $absences->count();
            $stats['total_bulletins'] += $bulletins->count();
            $stats['absences_non_justifiees'] += $absencesNonJustifiees;

            // Données détaillées
            $donneesEnfants[$enfant->id] = [
                'dernieres_notes' => $dernieresNotes,
                'dernieres_absences' => $dernieresAbsences,
                'moyenne_generale' => round($moyenneGenerale, 2),
                'dernier_bulletin' => $dernierBulletin,
                'absences_non_justifiees' => $absencesNonJustifiees,
                'total_notes' => $notes->count(),
                'total_absences' => $absences->count(),
                'total_bulletins' => $bulletins->count(),
                'stats_par_matiere' => $statsParMatiere,
                'progression' => $this->calculerProgression($notes),
            ];
        }

        // Graphique de progression (optionnel)
        $graphiqueData = $this->preparerGraphique($enfants);

        return view('parent.dashboard', compact(
            'enfants', 
            'stats', 
            'donneesEnfants',
            'graphiqueData'
        ));
    }

    /**
     * Vue quand aucun enfant n'est associé
     */
    private function vueVide()
    {
        return view('parent.dashboard', [
            'enfants' => collect([]),
            'stats' => [
                'total_enfants' => 0,
                'total_notes' => 0,
                'total_absences' => 0,
                'total_bulletins' => 0,
                'absences_non_justifiees' => 0,
            ],
            'donneesEnfants' => []
        ]);
    }

    /**
     * Calculer la progression des notes
     */
    private function calculerProgression($notes)
    {
        if ($notes->isEmpty()) {
            return [
                'tendance' => 'stable',
                'pourcentage' => 0
            ];
        }

        $premiereNote = $notes->last()->note ?? 0;
        $derniereNote = $notes->first()->note ?? 0;
        
        if ($premiereNote == 0) return ['tendance' => 'stable', 'pourcentage' => 0];
        
        $difference = $derniereNote - $premiereNote;
        $pourcentage = round(($difference / $premiereNote) * 100, 1);
        
        return [
            'tendance' => $difference > 0 ? 'hausse' : ($difference < 0 ? 'baisse' : 'stable'),
            'pourcentage' => abs($pourcentage)
        ];
    }

    /**
     * Préparer les données pour le graphique
     */
    private function preparerGraphique($enfants)
    {
        $data = [
            'labels' => [],
            'series' => []
        ];

        foreach ($enfants as $enfant) {
            $notes = Note::where('eleve_id', $enfant->id)
                ->with('evaluation')
                ->latest()
                ->take(10)
                ->get()
                ->reverse();

            if ($notes->isNotEmpty()) {
                $data['labels'] = $notes->pluck('evaluation.date_evaluation')
                    ->map(fn($date) => $date ? $date->format('d/m') : 'N/A')
                    ->toArray();
                
                $data['series'][] = [
                    'name' => $enfant->prenom,
                    'data' => $notes->pluck('note')->toArray()
                ];
            }
        }

        return $data;
    }
}