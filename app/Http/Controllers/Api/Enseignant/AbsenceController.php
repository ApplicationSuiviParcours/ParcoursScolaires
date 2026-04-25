<?php

namespace App\Http\Controllers\Api\Enseignant;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsenceResource;
use App\Models\Absence;
use App\Models\EnseignantMatiereClasse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AbsenceController extends Controller
{
    /**
     * List absences for enseignant's classes/matieres.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $enseignant = $user->enseignant;
        $classeId = $request->get('classe_id');
        $matiereId = $request->get('matiere_id');

        $matieresIds = EnseignantMatiereClasse::query()->where('enseignant_id', $enseignant->id)->pluck('matiere_id');

        $query = Absence::query()->whereIn('matiere_id', $matieresIds)
            ->with(['eleve', 'matiere']);

        if ($classeId) $query->whereHas('eleve.classe', fn($q) => $q->where('id', $classeId));
        if ($matiereId) $query->where('matiere_id', $matiereId);

        $absences = $query->orderBy('date_absence', 'desc')->paginate(20);

        return AbsenceResource::collection($absences);
    }

    /**
     * Mark absence for eleve/matiere/date.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $validator = Validator::make($request->all(), [
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'date_absence' => 'required|date',
            'justifiee' => 'boolean',
            'commentaire' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if enseignant teaches this matiere
        if (!EnseignantMatiereClasse::query()->where('enseignant_id', $user->enseignant->id)
            ->where('matiere_id', $request->matiere_id)->exists()) {
            abort(403, 'Matière non assignée');
        }

        $absence = Absence::create($validator->validated());

        return response()->json([
            'message' => 'Absence enregistrée',
            'absence' => new AbsenceResource($absence->load(['eleve', 'matiere'])),
        ], 201);
    }

    /**
     * Mark multiple absences (bulk).
     */
    public function bulkStore(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $validator = Validator::make($request->all(), [
            'matiere_id' => 'required|exists:matieres,id',
            'date_absence' => 'required|date',
            'absences' => 'required|array',
            'absences.*.eleve_id' => 'required|exists:eleves,id',
            'absences.*.justifiee' => 'boolean',
            'absences.*.commentaire' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if enseignant teaches this matiere
        if (!EnseignantMatiereClasse::query()->where('enseignant_id', $user->enseignant->id)
            ->where('matiere_id', $request->matiere_id)->exists()) {
            abort(403, 'Matière non assignée');
        }

        $results = [];
        foreach ($request->absences as $absenceData) {
            $results[] = Absence::create([
                'eleve_id' => $absenceData['eleve_id'],
                'matiere_id' => $request->matiere_id,
                'date_absence' => $request->date_absence,
                'justifiee' => $absenceData['justifiee'] ?? false,
                'commentaire' => $absenceData['commentaire'] ?? null,
            ]);
        }

        return response()->json([
            'message' => count($results) . ' absences enregistrées',
        ]);
    }
}