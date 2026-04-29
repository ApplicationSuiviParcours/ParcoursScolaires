<?php

namespace App\Http\Controllers\Api\Parent;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmploiDuTempsResource;
use App\Http\Resources\ClasseResource;
use App\Http\Resources\AnneeScolaireResource;
use App\Models\EmploiDuTemps;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class EmploiController extends Controller
{
    /**
     * Get emploi du temps for specific eleve.
     */
    public function show(Request $request, $eleve_id): AnonymousResourceCollection
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isParent()) abort(403);

        $eleve = Eleve::findOrFail($eleve_id);
        $annee_id = $request->get('annee_scolaire_id') ?? $eleve->inscriptionActive?->annee_scolaire_id;
        $classe_id = $eleve->classe_id ?? $eleve->inscriptionActive?->classe_id;

        if (!$classe_id || !$annee_id) {
            return EmploiDuTempsResource::collection(collect([]));
        }

        $query = EmploiDuTemps::query()->where('classe_id', $classe_id)
            ->where('annee_scolaire_id', $annee_id)
            ->with(['matiere', 'enseignant.user', 'classe', 'anneeScolaire']);

        $emplois = $query->orderBy('jour')->orderBy('heure_debut')->paginate(20);

        $classe = $classe_id ? Classe::find($classe_id) : null;
        $annee = $annee_id ? AnneeScolaire::find($annee_id) : null;

        return EmploiDuTempsResource::collection($emplois)->additional([
            'filters' => [
                'classe' => $classe ? new ClasseResource($classe) : null,
                'annee' => $annee ? new AnneeScolaireResource($annee) : null,
            ]
        ]);
    }
}