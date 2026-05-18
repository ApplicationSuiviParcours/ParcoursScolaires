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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user || !$user->isParent()) {
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
            $notesStats = Note::query()->whereIn('eleve_id', $enfantIds)
                ->select('eleve_id', 
                    DB::raw('count(*) as count'),
                    DB::raw('avg(note) as moyenne')
                )
                ->groupBy('eleve_id')
                ->get()
                ->keyBy('eleve_id');

            $absencesStats = Absence::query()->whereIn('eleve_id', $enfantIds)
                ->select('eleve_id', 
                    DB::raw('count(*) as count'),
                    DB::raw('SUM(CASE WHEN justifiee = 0 THEN 1 ELSE 0 END) as non_justifiees')
                )
                ->groupBy('eleve_id')
                ->get()
                ->keyBy('eleve_id');

            $bulletinsStats = Bulletin::query()->whereIn('eleve_id', $enfantIds)
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

    /**
     * Affiche le parcours complet d'un enfant spécifique pour le parent
     */
    public function parcoursEnfant(Eleve $eleve)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Vérifier que c'est bien l'enfant du parent
        $parent = $user->parentEleve;
        if (!$parent || !$parent->eleves()->where('eleve_id', $eleve->id)->exists()) {
            abort(403, 'Vous n\'êtes pas autorisé à consulter le parcours de cet élève.');
        }

        // Charger l'historique via l'attribut du modèle
        $historique = $eleve->historique_classes;

        // Calculer quelques statistiques globales pour le parcours
        $statsParcours = [
            'nombre_annees' => $historique->count(),
            'premiere_annee' => $historique->last()['annee_scolaire']->nom ?? 'N/A',
            'derniere_annee' => $historique->first()['annee_scolaire']->nom ?? 'N/A',
            'moyenne_globale' => $eleve->moyenne_generale,
            'total_bulletins' => $eleve->bulletins->count(),
        ];

        return view('parent.enfant-parcours', compact('eleve', 'historique', 'statsParcours'));
    }

    /**
     * Exporter le certificat de réussite d'un enfant au format PDF pour les parents
     */
    public function exportCertificatEnfantPdf(Eleve $eleve, $anneeScolaireId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $parent = $user->parentEleve;

        if (!$parent || !$parent->eleves()->where('eleve_id', $eleve->id)->exists()) {
            abort(403, 'Vous n\'êtes pas autorisé à consulter le parcours de cet élève.');
        }

        $anneeScolaire = \App\Models\AnneeScolaire::findOrFail($anneeScolaireId);

        // Récupérer l'inscription de l'élève pour cette année scolaire
        $inscription = \App\Models\Inscription::where('eleve_id', $eleve->id)
            ->where('annee_scolaire_id', $anneeScolaire->id)
            ->with('classe')
            ->first();

        if (!$inscription) {
            return redirect()->back()
                ->with('error', 'Aucune inscription trouvée pour l\'année scolaire demandée.');
        }

        // Récupérer les bulletins de cette année scolaire
        $bulletinsAnnee = $eleve->bulletins->where('annee_scolaire_id', $anneeScolaire->id);
        $moyenneAnnee = $bulletinsAnnee->isNotEmpty() ? round($bulletinsAnnee->avg('moyenne_generale'), 2) : null;

        if ($moyenneAnnee === null || $moyenneAnnee < 10) {
            return redirect()->back()
                ->with('error', 'Le certificat de réussite n\'est pas disponible car la moyenne annuelle est insuffisante ou non calculée.');
        }

        // Calculer la mention
        $mention = 'Passable';
        if ($moyenneAnnee >= 16) {
            $mention = 'Très Bien';
        } elseif ($moyenneAnnee >= 14) {
            $mention = 'Bien';
        } elseif ($moyenneAnnee >= 12) {
            $mention = 'Assez Bien';
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('eleve.exports.certificat-pdf', compact('eleve', 'anneeScolaire', 'inscription', 'moyenneAnnee', 'mention'));
        $pdf->setPaper('A4', 'landscape');

        $filename = 'certificat_reussite_' . $eleve->matricule . '_' . str_replace('/', '-', $anneeScolaire->nom) . '.pdf';

        return $pdf->download($filename);
    }
}