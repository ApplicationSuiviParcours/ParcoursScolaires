<?php

namespace App\Http\Controllers\Api\Eleve;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * List own notes with filters.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $user = Auth::user();
        if (!$user->isEleve()) abort(403);

        $eleve = $user->eleve;
        if (!$eleve) abort(404);

        $query = Note::where('eleve_id', $eleve->id)
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
            'total_notes' => Note::where('eleve_id', $eleve->id)->count(),
            'moyenne_generale' => round(Note::where('eleve_id', $eleve->id)->avg('note') ?? 0, 2),
        ];

        $notes->additional(['stats' => $stats]);

        return NoteResource::collection($notes);
    }
}