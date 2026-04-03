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
            ->with(['classe', 'inscriptionActive.classe'])
            ->paginate(10);

        $enfants->getCollection()->transform(function ($enfant) {
            $notes = Note::where('eleve_id', $enfant->id)
                ->with(['evaluation.matiere'])
                ->latest()
                ->limit(5)
                ->get();

            $absences = Absence::where('eleve_id', $enfant->id)
                ->with(['matiere'])
                ->latest('date_absence')
                ->limit(5)
                ->get();

            $bulletins = Bulletin::where('eleve_id', $enfant->id)
                ->latest()
                ->limit(1)
                ->get();

            $enfant->stats = [
                'moyenne_generale' => round($notes->avg('note') ?? 0, 2),
                'total_notes' => $notes->count(),
                'total_absences' => $absences->count(),
                'absences_non_justifiees' => $absences->where('justifiee', false)->count(),
                'dernieres_notes' => $notes,
                'dernieres_absences' => $absences,
                'dernier_bulletin' => $bulletins->first(),
            ];

            return $enfant;
        });

        // Global stats
        $enfants->additional([
            'stats_global' => [
                'total_enfants' => $enfants->total(),
                'total_notes' => Note::whereHas('eleve.parents', fn($q) => $q->where('parent_eleve_id', $parent->id))->count(),
                'total_absences' => Absence::whereHas('eleve.parents', fn($q) => $q->where('parent_eleve_id', $parent->id))->count(),
            ]
        ]);

        return EleveResource::collection($enfants);
    }
}