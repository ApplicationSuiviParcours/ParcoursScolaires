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
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $user = Auth::user();
        if (!$user->isEleve()) abort(403);

        $eleve = $user->eleve;
        if (!$eleve) abort(404);

        $query = Bulletin::where('eleve_id', $eleve->id)
            ->with(['classe', 'anneeScolaire']);

        if ($request->filled('periode')) $query->where('periode', $request->periode);
        if ($request->filled('annee_scolaire_id')) $query->where('annee_scolaire_id', $request->annee_scolaire_id);

        $bulletins = $query->orderBy('date_bulletin', 'desc')->paginate(12);

        $periodes = Bulletin::where('eleve_id', $eleve->id)->distinct('periode')->pluck('periode');

        $bulletins->additional([
            'stats' => [
                'total' => Bulletin::where('eleve_id', $eleve->id)->count(),
                'moyenne_globale' => round(Bulletin::where('eleve_id', $eleve->id)->avg('moyenne_generale') ?? 0, 2),
            ],
            'filters' => ['periodes' => $periodes],
        ]);

        return BulletinResource::collection($bulletins);
    }

    /**
     * Show own bulletin details with notes.
     */
    public function show($bulletin_id): JsonResponse
    {
        $user = Auth::user();
        if (!$user->isEleve()) abort(403);

        $bulletin = Bulletin::with(['classe', 'anneeScolaire'])->findOrFail($bulletin_id);
        if ($bulletin->eleve->user_id != $user->id) abort(403);

        $notes = DB::table('bulletin_note')
            ->join('notes', 'bulletin_note.note_id', '=', 'notes.id')
            ->join('evaluations', 'notes.evaluation_id', '=', 'evaluations.id')
            ->join('matieres', 'evaluations.matiere_id', '=', 'matieres.id')
            ->where('bulletin_note.bulletin_id', $bulletin_id)
            ->select('notes.note', 'evaluations.nom', 'evaluations.date_evaluation', 'evaluations.coefficient', 'matieres.nom as matiere_nom', 'bulletin_note.coefficient', 'bulletin_note.appreciation')
            ->get();

        $bulletin->notes = $notes;
        $bulletin->moyenne_generale = $bulletin->moyenne_generale ?? round($notes->avg('note') ?? 0, 2);

        return response()->json(new BulletinResource($bulletin));
    }
}