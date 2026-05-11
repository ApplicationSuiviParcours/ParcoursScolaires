<?php

namespace App\Http\Controllers\Api\Parent;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsenceResource;
use App\Models\Absence;
use App\Models\Matiere;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    /**
     * List absences for eleve with filters.
     */
    public function index(Request $request, $eleve_id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isParent()) abort(403);

        $eleve = Eleve::findOrFail($eleve_id);

        $query = Absence::query()->where('eleve_id', $eleve_id)
            ->with(['matiere']);

        if ($request->filled('date_debut')) $query->where('date_absence', '>=', $request->date_debut);
        if ($request->filled('date_fin')) $query->where('date_absence', '<=', $request->date_fin);
        if ($request->filled('matiere_id')) $query->where('matiere_id', $request->matiere_id);
        if ($request->filled('justifiee')) $query->where('justifiee', $request->justifiee);
        if ($request->filled('annee_scolaire_id')) $query->where('annee_scolaire_id', $request->annee_scolaire_id);

        $absences = $query->orderBy('date_absence', 'desc')->paginate(15);

        $statsQuery = Absence::query()->where('eleve_id', $eleve_id);
        if ($request->filled('annee_scolaire_id')) {
            $statsQuery->where('annee_scolaire_id', $request->annee_scolaire_id);
        }

        $stats = [
            'total' => (clone $statsQuery)->count(),
            'justifiees' => (clone $statsQuery)->where('justifiee', true)->count(),
            'non_justifiees' => (clone $statsQuery)->where('justifiee', false)->count(),
        ];

        return AbsenceResource::collection($absences)->additional(['stats' => $stats]);
    }

    /**
     * Justify an absence.
     */
    public function justifier(Request $request, $eleve_id, $absence_id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isParent()) abort(403);

        $request->validate([
            'motif' => 'required|string|max:500',
        ]);

        $absence = Absence::query()->where('eleve_id', $eleve_id)->findOrFail($absence_id);

        try {
            $absence->motif = $request->motif;
            $absence->justifiee = true;
            $absence->save();

            return response()->json([
                'message' => 'Absence justifiée avec succès.',
                'absence' => new AbsenceResource($absence)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la justification.'], 500);
        }
    }
}