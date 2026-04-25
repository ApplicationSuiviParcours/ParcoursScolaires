<?php

namespace App\Http\Controllers\Api\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\EnseignantMatiereClasse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ClasseController extends Controller
{
    /**
     * Get students of a class taught by the enseignant.
     */
    public function eleves($id): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $enseignant = $user->enseignant;
        
        // Verify the teacher teaches this class
        $teaches = EnseignantMatiereClasse::query()->where('enseignant_id', $enseignant->id)
            ->where('classe_id', $id)
            ->exists();
            
        if (!$teaches) abort(403, 'Vous n\'enseignez pas dans cette classe.');

        $classe = Classe::query()->with(['eleves' => function ($query) {
            $query->orderBy('nom')->orderBy('prenom');
        }])->findOrFail($id);

        $eleves = $classe->eleves->map(function ($eleve) {
            return [
                'id' => $eleve->id,
                'nom' => $eleve->nom,
                'prenom' => $eleve->prenom,
                'matricule' => $eleve->matricule,
                'photo' => $eleve->photo,
            ];
        });

        return response()->json([
            'classe' => [
                'id' => $classe->id,
                'nom' => $classe->nom ?? $classe->nom_complet,
            ],
            'eleves' => $eleves
        ]);
    }
}
