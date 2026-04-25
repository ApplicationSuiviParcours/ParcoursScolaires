<?php

namespace App\Http\Controllers\Api\Eleve;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * List own notes with filters.
     */
    public function index(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEleve()) abort(403);

        $eleve = $user->eleve;
        if (!$eleve) abort(404);

        $query = Note::query()->where('eleve_id', $eleve->id)
            ->with(['evaluation.matiere']);

        if ($request->filled('matiere_id')) {
            $query->whereHas('evaluation', fn($q) => $q->where('matiere_id', $request->matiere_id));
        }
        if ($request->filled('periode')) {
            $query->whereHas('evaluation', fn($q) => $q->where('periode', $request->periode));
        }
        if ($request->filled('date_debut')) {
            $query->whereHas('evaluation', fn($q) => $q->where('date_evaluation', '>=', $request->date_debut));
        }
        if ($request->filled('date_fin')) {
            $query->whereHas('evaluation', fn($q) => $q->where('date_evaluation', '<=', $request->date_fin));
        }

        $notes = $query->orderBy('created_at', 'desc')->get();
        
        $stats = [
            'total_notes' => Note::query()->where('eleve_id', $eleve->id)->count(),
            'moyenne_generale' => round(Note::query()->where('eleve_id', $eleve->id)->avg('note') ?? 0, 2),
        ];

        return response()->json([
            'notes' => NoteResource::collection($notes),
            'stats' => $stats,
        ]);
    }
}