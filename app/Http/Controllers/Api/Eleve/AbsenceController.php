<?php

namespace App\Http\Controllers\Api\Eleve;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsenceResource;
use App\Models\Absence;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    /**
     * List own absences with filters.
     */
    public function index(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEleve()) abort(403);

        $eleve = $user->eleve;
        if (!$eleve) abort(404);

        $query = Absence::query()->where('eleve_id', $eleve->id)
            ->with(['matiere']);

        if ($request->filled('date_debut')) $query->where('date_absence', '>=', $request->date_debut);
        if ($request->filled('date_fin')) $query->where('date_absence', '<=', $request->date_fin);
        if ($request->filled('matiere_id')) $query->where('matiere_id', $request->matiere_id);
        if ($request->filled('justifiee')) $query->where('justifiee', $request->justifiee);

        $absences = $query->orderBy('date_absence', 'desc')->get();

        $stats = [
            'total' => Absence::query()->where('eleve_id', $eleve->id)->count(),
            'justifiees' => Absence::query()->where('eleve_id', $eleve->id)->where('justifiee', true)->count(),
            'non_justifiees' => Absence::query()->where('eleve_id', $eleve->id)->where('justifiee', false)->count(),
        ];

        return response()->json([
            'absences' => AbsenceResource::collection($absences),
            'stats' => $stats,
        ]);
    }
}