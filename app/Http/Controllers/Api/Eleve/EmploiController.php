<?php

namespace App\Http\Controllers\Api\Eleve;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmploiDuTempsResource;
use App\Models\EmploiDuTemps;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EmploiController extends Controller
{
    /**
     * Get own emploi du temps.
     */
    public function index(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEleve()) abort(403);

        $eleve = $user->eleve;
        if (!$eleve) abort(404);

        $annee_id = $request->get('annee_scolaire_id') ?? $eleve->inscriptionActive?->annee_scolaire_id;
        $classe_id = $eleve->classe_actuelle?->id ?? $eleve->inscriptionActive?->classe_id;

        if (!$classe_id || !$annee_id) {
            return response()->json([
                'emploi' => [],
                'info' => [
                    'classe_id' => $classe_id,
                    'annee_id' => $annee_id,
                ]
            ]);
        }

        $query = EmploiDuTemps::query()->where('classe_id', $classe_id)
            ->where('annee_scolaire_id', $annee_id)
            ->with(['matiere', 'enseignant.user']);

        $emplois = $query->orderBy('jour')->orderBy('heure_debut')->get();

        return response()->json([
            'emploi' => EmploiDuTempsResource::collection($emplois),
            'info' => [
                'classe_id' => $classe_id,
                'annee_id' => $annee_id,
            ]
        ]);
    }
}