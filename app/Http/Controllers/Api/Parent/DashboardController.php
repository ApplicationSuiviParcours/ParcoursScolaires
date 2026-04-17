<?php

namespace App\Http\Controllers\Api\Parent;

use App\Http\Controllers\Controller;
use App\Http\Resources\EleveResource;
use App\Models\Note;
use App\Models\Absence;
use App\Models\Bulletin;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Get parent dashboard data (children stats, recent notes/absences/bulletins).
     */
    public function index(): AnonymousResourceCollection
    {
        $user = Auth::user();
        
        if (!$user->isParent()) {
            abort(403, 'Accès non autorisé.');
        }

        $parent = $user->parentEleve;
        if (!$parent) {
            return EleveResource::collection(collect([]));
        }

        $enfants = $parent->eleves()
            ->with(['inscriptionActive.classe.anneeScolaire'])
            ->get();

        $enfants->transform(function ($enfant) {
            $allNotes = Note::where('eleve_id', $enfant->id)
                ->with(['evaluation.matiere'])
                ->get();

            $notesParMatiere = [];
            foreach ($allNotes as $note) {
                if ($note->evaluation && $note->evaluation->matiere) {
                    $mId = $note->evaluation->matiere->id;
                    if (!isset($notesParMatiere[$mId])) {
                        $notesParMatiere[$mId] = [
                            'nom' => $note->evaluation->matiere->nom,
                            'somme' => 0, 'count' => 0
                        ];
                    }
                    $notesParMatiere[$mId]['somme'] += $note->note;
                    $notesParMatiere[$mId]['count']++;
                }
            }

            $moyennesParMatiere = collect($notesParMatiere)->map(fn($m) => [
                'nom' => $m['nom'],
                'moyenne' => round($m['somme'] / $m['count'], 2),
                'nb_notes' => $m['count']
            ])->values();

            $absences = Absence::where('eleve_id', $enfant->id)
                ->with(['matiere'])
                ->latest('date_absence')
                ->limit(5)
                ->get();

            $bulletinCourant = Bulletin::where('eleve_id', $enfant->id)
                ->latest()
                ->first();

            $enfant->stats = [
                'moyenne_generale' => $enfant->moyenne_generale ?? ($allNotes->avg('note') ? round($allNotes->avg('note'), 2) : 0),
                'total_notes' => $allNotes->count(),
                'total_absences' => $enfant->absences()->count(),
                'absences_non_justifiees' => $enfant->absences()->where('justifiee', false)->count(),
                'moyennes_par_matiere' => $moyennesParMatiere,
                'dernieres_notes' => NoteResource::collection($allNotes->take(5)),
                'dernieres_absences' => AbsenceResource::collection($absences),
                'dernier_bulletin' => $bulletinCourant ? [
                    'periode' => $bulletinCourant->periode,
                    'moyenne' => $bulletinCourant->moyenne_generale,
                    'rang' => $bulletinCourant->rang,
                ] : null,
            ];

            return $enfant;
        });

        // Global stats for parent
        $statsGlobal = [
            'total_enfants' => $enfants->count(),
            'total_notes' => Note::whereHas('eleve.parents', fn($q) => $q->where('parent_eleve_id', $parent->id))->count(),
            'total_absences' => Absence::whereHas('eleve.parents', fn($q) => $q->where('parent_eleve_id', $parent->id))->count(),
        ];

        return EleveResource::collection($enfants)->additional(['stats_global' => $statsGlobal]);
    }
}