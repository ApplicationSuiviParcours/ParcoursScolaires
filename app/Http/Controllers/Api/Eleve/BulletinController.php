<?php

namespace App\Http\Controllers\Api\Eleve;

use App\Http\Controllers\Controller;
use App\Http\Resources\BulletinResource;
use App\Models\Bulletin;
use App\Models\Eleve;
use App\Models\Note;
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

        // 1. Récupération des notes (essayer pivot d'abord, puis direct)
        $notes = DB::table('bulletin_note')
            ->join('notes', 'bulletin_note.note_id', '=', 'notes.id')
            ->join('evaluations', 'notes.evaluation_id', '=', 'evaluations.id')
            ->join('matieres', 'evaluations.matiere_id', '=', 'matieres.id')
            ->where('bulletin_note.bulletin_id', $bulletin->id)
            ->select('notes.note', 'matieres.nom as matiere_nom', 'bulletin_note.coefficient', 'bulletin_note.appreciation', 'evaluations.nom as evaluation_nom')
            ->get();

        if ($notes->isEmpty()) {
            // Backup : Récupération directe si la table pivot est vide
            $notesDirectes = Note::query()->where('eleve_id', $bulletin->eleve_id)
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
                    'evaluation_nom' => $n->evaluation->nom ?? 'Évaluation',
                ];
            });
        }

        // 2. Calcul de la moyenne de classe et effectif
        $moyenneClasse = $bulletin->moyenne_classe;
        if (!$moyenneClasse || $moyenneClasse == 0) {
            $moyenneClasse = Bulletin::query()
                ->where('classe_id', $bulletin->classe_id)
                ->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
                ->where('periode', $bulletin->periode)
                ->avg('moyenne_generale') ?? 0;
        }

        $effectifClasse = $bulletin->effectif_classe;
        if (!$effectifClasse || $effectifClasse == 0) {
            $effectifClasse = Bulletin::query()
                ->where('classe_id', $bulletin->classe_id)
                ->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
                ->where('periode', $bulletin->periode)
                ->count();
        }

        // 3. Format de réponse plat et complet (pour éviter les soucis de Resource)
        return response()->json([
            'data' => [
                'id' => $bulletin->id,
                'periode' => $bulletin->periode,
                'date_bulletin' => $bulletin->date_bulletin->format('Y-m-d'),
                'moyenne_generale' => round((float)$bulletin->moyenne_generale, 2),
                'moyenne_classe' => round((float)$moyenneClasse, 2),
                'ecart_classe' => round((float)$bulletin->moyenne_generale - (float)$moyenneClasse, 2),
                'effectif_classe' => (int)$effectifClasse,
                'rang' => (int)$bulletin->rang,
                'appreciation' => $bulletin->appreciation_generale ?? $bulletin->appreciation ?? 'Bon travail global',
                'notes' => $notes->map(function($n) {
                    return [
                        'note' => (float)$n->note,
                        'matiere_nom' => $n->matiere_nom,
                        'nom' => $n->matiere_nom, // Doublon pour la robustesse
                        'coefficient' => (int)$n->coefficient,
                        'appreciation' => $n->appreciation ?? '',
                        'evaluation_nom' => $n->evaluation_nom,
                    ];
                }),
                'classe' => ['nom' => $bulletin->classe->nom],
                'annee_scolaire' => ['nom' => $bulletin->anneeScolaire->nom]
            ]
        ]);
    }
}