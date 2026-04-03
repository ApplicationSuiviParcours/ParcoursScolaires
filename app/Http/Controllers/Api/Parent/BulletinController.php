<?php

namespace App\Http\Controllers\Api\Parent;

use App\Http\Controllers\Controller;
use App\Http\Resources\BulletinResource;
use App\Models\Bulletin;
use App\Models\AnneeScolaire;
use App\Models\Eleve;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BulletinController extends Controller
{
    /**
     * List bulletins for child's eleve_id, with filters.
     */
    public function index(Request $request, $eleve_id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $user = Auth::user();
        if (!$user->isParent()) abort(403);

        $eleve = Eleve::findOrFail($eleve_id);
        // TODO: Check if parent has access to this eleve (via eleve_parents)

        $query = Bulletin::where('eleve_id', $eleve_id)
            ->with(['classe', 'anneeScolaire']);

        if ($request->filled('periode')) $query->where('periode', $request->periode);
        if ($request->filled('annee_scolaire_id')) $query->where('annee_scolaire_id', $request->annee_scolaire_id);

        $bulletins = $query->orderBy('date_bulletin', 'desc')->paginate(12);

        $periodes = Bulletin::where('eleve_id', $eleve_id)->distinct('periode')->pluck('periode');
        $annees = AnneeScolaire::whereIn('id', Bulletin::where('eleve_id', $eleve_id)->distinct('annee_scolaire_id')->pluck('annee_scolaire_id'))->get(['id', 'libelle']);

        $bulletins->additional([
            'stats' => [
                'total' => Bulletin::where('eleve_id', $eleve_id)->count(),
                'moyenne_globale' => round(Bulletin::where('eleve_id', $eleve_id)->avg('moyenne_generale') ?? 0, 2),
            ],
            'filters' => ['periodes' => $periodes, 'annees' => $annees]
        ]);

        return BulletinResource::collection($bulletins);
    }

    /**
     * Show bulletin details with notes.
     */
    public function show($eleve_id, $bulletin_id): JsonResponse
    {
        $user = Auth::user();
        if (!$user->isParent()) abort(403);

        $bulletin = Bulletin::with(['classe', 'anneeScolaire'])->findOrFail($bulletin_id);
        if ($bulletin->eleve_id != $eleve_id) abort(404);

        // Notes (adapt from web controller logic - using bulletin_note pivot)
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