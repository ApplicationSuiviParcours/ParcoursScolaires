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

        $absences = $query->orderBy('date_absence', 'desc')->paginate(15);

        $stats = [
            'total' => Absence::query()->where('eleve_id', $eleve_id)->count(),
            'justifiees' => Absence::query()->where('eleve_id', $eleve_id)->where('justifiee', true)->count(),
            'non_justifiees' => Absence::query()->where('eleve_id', $eleve_id)->where('justifiee', false)->count(),
        ];

        $absences->additional(['stats' => $stats]);

        return AbsenceResource::collection($absences);
    }
}