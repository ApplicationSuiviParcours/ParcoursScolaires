<?php

namespace App\Http\Controllers\Api\Enseignant;

use App\Http\Controllers\Controller;
use App\Http\Resources\EvaluationResource;
use App\Models\Evaluation;
use App\Models\EnseignantMatiereClasse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EvaluationController extends Controller
{
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $enseignant = $user->enseignant;
        $matiereId = $request->get('matiere_id');
        $classeId = $request->get('classe_id');

        $query = Evaluation::query()->where('enseignant_id', $enseignant->id)
            ->with(['matiere', 'classe']);

        if ($matiereId) $query->where('matiere_id', $matiereId);
        if ($classeId) $query->where('classe_id', $classeId);

        $evaluations = $query->orderBy('date_evaluation', 'desc')->paginate(20);

        return EvaluationResource::collection($evaluations);
    }

    public function store(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $validator = Validator::make($request->all(), [
            'matiere_classe_id' => 'required|exists:enseignant_matiere_classe,id',
            'nom' => 'required|string|max:255',
            'date_evaluation' => 'required|date',
            'periode' => 'required|string',
            'coefficient' => 'required|numeric|min:1|max:5',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $mc = EnseignantMatiereClasse::findOrFail($request->matiere_classe_id);
        if ($mc->enseignant_id != $user->enseignant->id) abort(403);

        $evaluation = Evaluation::create([
            'nom' => $request->nom,
            'date_evaluation' => $request->date_evaluation,
            'periode' => $request->periode,
            'coefficient' => $request->coefficient,
            'description' => $request->description,
            'enseignant_id' => $mc->enseignant_id,
            'matiere_id' => $mc->matiere_id,
            'classe_id' => $mc->classe_id,
            'annee_scolaire_id' => $mc->annee_scolaire_id,
            'type' => $request->get('type', 'devoir'),
        ]);

        return response()->json([
            'message' => 'Évaluation créée avec succès',
            'evaluation' => new EvaluationResource($evaluation->load(['matiere', 'classe'])),
        ], 201);
    }

    public function show($id): EvaluationResource
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $evaluation = Evaluation::query()->with(['enseignant', 'notes.eleve'])
            ->findOrFail($id);

        if ($evaluation->enseignant_id != $user->enseignant->id) abort(403);

        return new EvaluationResource($evaluation);
    }

    public function update(Request $request, $id): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $evaluation = Evaluation::findOrFail($id);
        if ($evaluation->enseignant->user_id != $user->id) abort(403);

        $validator = Validator::make($request->all(), [
            'nom' => 'string|max:255',
            'date_evaluation' => 'date',
            'periode' => 'string',
            'coefficient' => 'numeric|min:1|max:5',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $evaluation->update($validator->validated());

        return response()->json([
            'message' => 'Évaluation mise à jour',
            'evaluation' => new EvaluationResource($evaluation->load(['matiere', 'classe'])),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $evaluation = Evaluation::findOrFail($id);
        if ($evaluation->enseignant->user_id != $user->id) abort(403);

        $evaluation->delete();

        return response()->json(['message' => 'Évaluation supprimée']);
    }
}