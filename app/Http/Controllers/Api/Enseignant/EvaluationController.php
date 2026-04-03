<?php

namespace App\Http\Controllers\Api\Enseignant;

use App\Http\Controllers\Controller;
use App\Http\Resources\EvaluationResource;
use App\Models\Evaluation;
use App\Models\EnseignantMatiereClasse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->isEnseignant()) abort(403);

        $enseignant = $user->enseignant;
        $matiereClasseId = $request->get('matiere_classe_id');
        $classeId = $request->get('classe_id');

        $query = Evaluation::whereHas('matiereClasse.enseignant', fn($q) => $q->where('id', $enseignant->id))
            ->with(['matiereClasse.matiere', 'matiereClasse.classe']);

        if ($matiereClasseId) $query->where('matiere_classe_id', $matiereClasseId);
        if ($classeId) $query->whereHas('matiereClasse.classe', fn($q) => $q->where('id', $classeId));

        $evaluations = $query->orderBy('date_evaluation', 'desc')->paginate(20);

        return EvaluationResource::collection($evaluations);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isEnseignant()) abort(403);

        $validator = Validator::make($request->all(), [
            'matiere_classe_id' => 'required|exists:enseignant_matiere_classes,id',
            'nom' => 'required|string|max:255',
            'date_evaluation' => 'required|date',
            'periode' => 'required|string',
            'coefficient' => 'required|numeric|min:1|max:5',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $evaluation = Evaluation::create($validator->validated());

        return response()->json([
            'message' => 'Évaluation créée avec succès',
            'evaluation' => new EvaluationResource($evaluation->load('matiereClasse')),
        ], 201);
    }

    public function show($id)
    {
        $user = Auth::user();
        if (!$user->isEnseignant()) abort(403);

        $evaluation = Evaluation::with(['matiereClasse.enseignant', 'notes.eleve'])
            ->findOrFail($id);

        if ($evaluation->matiereClasse->enseignant->user_id != $user->id) abort(403);

        return new EvaluationResource($evaluation);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isEnseignant()) abort(403);

        $evaluation = Evaluation::findOrFail($id);
        if ($evaluation->matiereClasse->enseignant->user_id != $user->id) abort(403);

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
            'evaluation' => new EvaluationResource($evaluation->load('matiereClasse')),
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->isEnseignant()) abort(403);

        $evaluation = Evaluation::findOrFail($id);
        if ($evaluation->matiereClasse->enseignant->user_id != $user->id) abort(403);

        $evaluation->delete();

        return response()->json(['message' => 'Évaluation supprimée']);
    }
}