<?php

namespace App\Http\Controllers\Api\Parent;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\Matiere;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * List notes for eleve with filters.
     */
    public function index(Request $request, $eleve_id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isParent()) abort(403);

        $eleve = Eleve::findOrFail($eleve_id);

        $query = Note::query()->where('eleve_id', $eleve_id)
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

        $notes = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total_notes' => Note::query()->where('eleve_id', $eleve_id)->count(),
            'moyenne_generale' => round(Note::query()->where('eleve_id', $eleve_id)->avg('note') ?? 0, 2),
        ];

        $notes->additional(['stats' => $stats]);

        return NoteResource::collection($notes);
    }
}