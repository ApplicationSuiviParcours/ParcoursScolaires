<?php

namespace App\Http\Controllers\Api\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) abort(401);
        $eleve = $user->eleve;
        
        if (!$eleve) abort(404);

        $classeId = $eleve->inscriptionActive?->classe_id;
        
        if (!$classeId) {
            return response()->json(['data' => []]);
        }

        // Récupérer les évaluations à venir pour la classe de l'élève
        $evaluations = Evaluation::query()->where('classe_id', $classeId)
            ->with(['matiere', 'enseignant'])
            ->where('date_evaluation', '>=', now())
            ->orderBy('date_evaluation', 'asc')
            ->get();

        return response()->json([
            'data' => $evaluations->map(function ($ev) {
                return [
                    'id' => $ev->id,
                    'titre' => $ev->nom,
                    'matiere' => $ev->matiere?->nom,
                    'date' => $ev->date_evaluation,
                    'description' => $ev->description,
                    'type' => 'Évaluation',
                ];
            })
        ]);
    }
}
