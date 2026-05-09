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

        // 1. Récupérer les notes (essayer pivot d'abord, puis direct)
        $notes = DB::table('bulletin_note')
            ->join('notes', 'bulletin_note.note_id', '=', 'notes.id')
            ->join('evaluations', 'notes.evaluation_id', '=', 'evaluations.id')
            ->join('matieres', 'evaluations.matiere_id', '=', 'matieres.id')
            ->where('bulletin_note.bulletin_id', $bulletin_id)
            ->select('notes.note', 'evaluations.nom', 'evaluations.coefficient', 'matieres.nom as matiere_nom', 'bulletin_note.appreciation')
            ->get();

        if ($notes->isEmpty()) {
            $notesDirectes = \App\Models\Note::query()->where('eleve_id', $bulletin->eleve_id)
                ->whereHas('evaluation', function($q) use ($bulletin) {
                    $q->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
                      ->where('periode', $bulletin->periode);
                })
                ->with(['evaluation.matiere'])
                ->get();

            $notes = $notesDirectes->map(function($n) {
                return (object)[
                    'note' => $n->note,
                    'matiere_nom' => $n->evaluation->matiere->nom ?? 'Inconnu',
                    'coefficient' => $n->evaluation->coefficient ?? 1,
                    'appreciation' => $n->appreciation ?? '',
                ];
            });
        }

        // 2. Regrouper par matière
        $notesByMatiere = $notes->groupBy('matiere_nom');
        $finalNotes = [];
        
        foreach ($notesByMatiere as $matiereNom => $matiereNotes) {
            $totalPointsEval = 0;
            $totalCoeffsEval = 0;
            
            foreach ($matiereNotes as $n) {
                $coeffEval = (float)($n->coefficient ?? 1);
                $totalPointsEval += (float)$n->note * $coeffEval;
                $totalCoeffsEval += $coeffEval;
            }
            
            $moyenneMatiere = $totalCoeffsEval > 0 ? $totalPointsEval / $totalCoeffsEval : 0;

            $finalNotes[] = [
                'note' => round($moyenneMatiere, 2),
                'matiere_nom' => $matiereNom,
                'nom' => $matiereNom,
                'coefficient' => 1, 
                'appreciation' => $this->getAppreciation($moyenneMatiere),
            ];
        }

        $bulletin->setAttribute('notes_manuelles', $finalNotes);
        $bulletin->setAttribute('moyenne_generale', $bulletin->moyenne_generale ?? round($notes->avg('note') ?? 0, 2));

        return response()->json(new BulletinResource($bulletin));
    }

    private function getAppreciation(float $moyenne): string
    {
        if ($moyenne >= 16) return 'Excellent';
        if ($moyenne >= 14) return 'Très Bien';
        if ($moyenne >= 12) return 'Bien';
        if ($moyenne >= 10) return 'Passable';
        return 'Insuffisant';
    }
}