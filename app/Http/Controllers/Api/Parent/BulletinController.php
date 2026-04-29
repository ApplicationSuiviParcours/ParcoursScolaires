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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isParent()) abort(403);

        $eleve = Eleve::findOrFail($eleve_id);
        // TODO: Check if parent has access to this eleve (via eleve_parents)

        $query = Bulletin::query()->where('eleve_id', $eleve_id)
            ->with(['classe', 'anneeScolaire']);

        if ($request->filled('periode')) $query->where('periode', $request->periode);
        if ($request->filled('annee_scolaire_id')) $query->where('annee_scolaire_id', $request->annee_scolaire_id);

        $bulletins = $query->orderBy('date_bulletin', 'desc')->paginate(12);

        $periodes = Bulletin::query()->where('eleve_id', $eleve_id)->distinct('periode')->pluck('periode');
        $annees = AnneeScolaire::query()->whereIn('id', Bulletin::query()->where('eleve_id', $eleve_id)->distinct('annee_scolaire_id')->pluck('annee_scolaire_id'))->get(['id', 'nom']);

        return BulletinResource::collection($bulletins)->additional([
            'stats' => [
                'total' => Bulletin::query()->where('eleve_id', $eleve_id)->count(),
                'moyenne_globale' => round(Bulletin::query()->where('eleve_id', $eleve_id)->avg('moyenne_generale') ?? 0, 2),
            ],
            'filters' => ['periodes' => $periodes, 'annees' => $annees]
        ]);
    }

    /**
     * Show bulletin details with notes.
     */
    public function show($eleve_id, $bulletin_id): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isParent()) abort(403);

        $bulletin = Bulletin::query()->with(['classe', 'anneeScolaire'])->findOrFail($bulletin_id);
        if ($bulletin->eleve_id != $eleve_id) abort(404);

        // Notes (adapt from web controller logic - using bulletin_note pivot)
        $notes = DB::table('bulletin_note')
            ->join('notes', 'bulletin_note.note_id', '=', 'notes.id')
            ->join('evaluations', 'notes.evaluation_id', '=', 'evaluations.id')
            ->join('matieres', 'evaluations.matiere_id', '=', 'matieres.id')
            ->where('bulletin_note.bulletin_id', $bulletin_id)
            ->select('notes.note', 'evaluations.nom', 'evaluations.date_evaluation', 'evaluations.coefficient', 'matieres.nom as matiere_nom', 'bulletin_note.coefficient', 'bulletin_note.appreciation')
            ->get();

        $bulletin->setAttribute('notes_manuelles', $notes);
        $bulletin->setAttribute('moyenne_generale', $bulletin->moyenne_generale ?? round($notes->avg('note') ?? 0, 2));

        return response()->json(new BulletinResource($bulletin));
    }
}