<?php

namespace App\Http\Controllers\Api\Eleve;

use App\Http\Controllers\Controller;
use App\Http\Resources\BulletinResource;
use App\Models\Bulletin;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BulletinController extends Controller
{
    /**
     * List own bulletins with filters.
     */
    public function index(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEleve()) abort(403);

        $eleve = $user->eleve;
        if (!$eleve) abort(404);

        $query = Bulletin::query()->where('eleve_id', $eleve->id)
            ->with(['classe', 'anneeScolaire']);

        if ($request->filled('periode')) $query->where('periode', $request->periode);
        if ($request->filled('annee_scolaire_id')) $query->where('annee_scolaire_id', $request->annee_scolaire_id);

        $bulletins = $query->orderBy('date_bulletin', 'desc')->get();

        $periodes = Bulletin::query()->where('eleve_id', $eleve->id)->distinct('periode')->pluck('periode');

        return response()->json([
            'bulletins' => BulletinResource::collection($bulletins),
            'stats' => [
                'total' => Bulletin::query()->where('eleve_id', $eleve->id)->count(),
                'moyenne_globale' => round(Bulletin::query()->where('eleve_id', $eleve->id)->avg('moyenne_generale') ?? 0, 2),
            ],
            'filters' => ['periodes' => $periodes],
        ]);
    }

    /**
     * Show own bulletin details with notes.
     */
    public function show($bulletin_id): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEleve()) abort(403);

        $bulletin = Bulletin::query()->with(['classe', 'anneeScolaire'])->findOrFail($bulletin_id);
        if ($bulletin->eleve->user_id != $user->id) abort(403);

        $notes = DB::table('bulletin_note')
            ->join('notes', 'bulletin_note.note_id', '=', 'notes.id')
            ->join('evaluations', 'notes.evaluation_id', '=', 'evaluations.id')
            ->join('matieres', 'evaluations.matiere_id', '=', 'matieres.id')
            ->where('bulletin_note.bulletin_id', $bulletin_id)
            ->select('notes.note', 'evaluations.nom', 'evaluations.date_evaluation', 'evaluations.coefficient', 'matieres.nom as matiere_nom', 'bulletin_note.coefficient', 'bulletin_note.appreciation')
            ->get();

        $bulletin->setAttribute('notes_manuelles', $notes);
        $bulletin->moyenne_generale = $bulletin->moyenne_generale ?? round($notes->avg('note') ?? 0, 2);

        return response()->json(new BulletinResource($bulletin));
    }
}