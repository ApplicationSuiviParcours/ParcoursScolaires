<?php

namespace App\Http\Controllers\Api\Enseignant;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    /**
     * List notes for enseignant's evaluations.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $evaluationId = $request->get('evaluation_id');
        $eleveId = $request->get('eleve_id');

        $query = Note::query()->whereHas('evaluation', fn($q) => $q->where('enseignant_id', $user->enseignant->id))
            ->with(['evaluation.matiere', 'eleve']);

        if ($evaluationId) $query->where('evaluation_id', $evaluationId);
        if ($eleveId) $query->where('eleve_id', $eleveId);

        $notes = $query->orderBy('created_at', 'desc')->paginate(20);

        return NoteResource::collection($notes);
    }

    /**
     * Store note for specific evaluation/eleve.
     */
    public function store(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $validator = Validator::make($request->all(), [
            'evaluation_id' => 'required|exists:evaluations,id',
            'eleve_id' => 'required|exists:eleves,id',
            'note' => 'required|numeric|min:0|max:20',
            'observation' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $evaluation = Evaluation::findOrFail($request->evaluation_id);
        if ($evaluation->enseignant_id != $user->enseignant->id) abort(403);

        $note = Note::updateOrCreate(
            [
                'evaluation_id' => $request->evaluation_id,
                'eleve_id' => $request->eleve_id,
            ],
            $validator->validated()
        );

        return response()->json([
            'message' => 'Note sauvegardée',
            'note' => new NoteResource($note->load(['evaluation', 'eleve'])),
        ], 201);
    }

    /**
     * Store multiple notes for an evaluation (bulk).
     */
    public function bulkStore(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $validator = Validator::make($request->all(), [
            'evaluation_id' => 'required|exists:evaluations,id',
            'notes' => 'required|array',
            'notes.*.eleve_id' => 'required|exists:eleves,id',
            'notes.*.note' => 'required|numeric|min:0|max:20',
            'notes.*.observation' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $evaluation = Evaluation::findOrFail($request->evaluation_id);
        if ($evaluation->enseignant_id != $user->enseignant->id) abort(403);

        $results = [];
        foreach ($request->notes as $noteData) {
            $results[] = Note::updateOrCreate(
                [
                    'evaluation_id' => $request->evaluation_id,
                    'eleve_id' => $noteData['eleve_id'],
                ],
                [
                    'note' => $noteData['note'],
                    'observation' => $noteData['observation'] ?? $noteData['appreciation'] ?? null,
                ]
            );
        }

        return response()->json([
            'message' => count($results) . ' notes sauvegardées',
        ]);
    }
}