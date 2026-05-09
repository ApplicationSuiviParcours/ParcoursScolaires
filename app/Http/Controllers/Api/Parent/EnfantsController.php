<?php

namespace App\Http\Controllers\Api\Parent;

use App\Http\Controllers\Controller;
use App\Http\Resources\EleveResource;
use App\Models\ParentEleve;
use App\Models\Eleve;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class EnfantsController extends Controller
{
    /**
     * List all enfants for authenticated parent.
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isParent()) {
            abort(403, 'Accès réservé aux parents.');
        }

        $parentEleve = ParentEleve::query()->whereHas('user', fn($q) => $q->where('id', $user->id))->first();
        if (!$parentEleve) {
            return EleveResource::collection(collect([]));
        }

        $enfants = $parentEleve->eleves()
            ->with(['classe', 'inscriptionActive.classe.anneeScolaire'])
            ->orderBy('nom', 'asc')
            ->paginate(20);

        // Add quick stats per enfant
        $enfants->getCollection()->transform(function ($eleve) {
            $eleve->setAttribute('quick_stats', [
                'moyenne' => round($eleve->notes()->avg('note') ?? 0, 2),
                'absences' => $eleve->absences()->count(),
                'bulletins' => $eleve->bulletins()->count(),
            ]);
            return $eleve;
        });

        $enfants->additional([
            'stats' => [
                'total_enfants' => $enfants->total(),
            ]
        ]);

        return EleveResource::collection($enfants);
    }

    /**
     * Get an enfant's full academic career (parcours).
     */
    public function parcoursEnfant(Request $request, $eleve_id): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isParent()) {
            abort(403, 'Accès réservé aux parents.');
        }

        $eleve = Eleve::find($eleve_id);
        if (!$eleve) {
            abort(404, 'Enfant non trouvé.');
        }

        // Check if this child belongs to the parent
        $parentEleve = ParentEleve::query()->whereHas('user', fn($q) => $q->where('id', $user->id))->first();
        if (!$parentEleve || !$parentEleve->eleves()->where('eleve_id', $eleve->id)->exists()) {
            abort(403, 'Vous n\'avez pas accès au parcours de cet élève.');
        }

        $historique = $eleve->historique_classes;

        return response()->json([
            'eleve' => [
                'id' => $eleve->id,
                'nom_complet' => $eleve->nom_complet,
                'matricule' => $eleve->matricule,
                'photo' => $eleve->photo ? asset('storage/' . $eleve->photo) : null,
            ],
            'stats' => [
                'nombre_annees' => $historique->count(),
                'moyenne_globale' => round($eleve->moyenne_generale ?? 0, 2),
                'total_bulletins' => $eleve->bulletins->count(),
            ],
            'historique' => $historique->map(function ($item) {
                return [
                    'annee_scolaire' => [
                        'id' => $item['annee_scolaire']->id,
                        'nom' => $item['annee_scolaire']->nom,
                    ],
                    'classe' => [
                        'id' => $item['classe']->id,
                        'nom' => $item['classe']->nom,
                        'niveau' => $item['classe']->niveau,
                    ],
                    'date_inscription' => $item['date_inscription'],
                    'statut' => $item['statut'],
                    'observation' => $item['observation'],
                ];
            }),
        ]);
    }
}