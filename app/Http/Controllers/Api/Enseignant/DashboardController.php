<?php

namespace App\Http\Controllers\Api\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Note;
use App\Models\Absence;
use App\Models\EnseignantMatiereClasse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Get enseignant dashboard: classes taught, stats, recent data.
     */
    public function index(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isEnseignant()) abort(403);

        $enseignant = $user->enseignant;
        if (!$enseignant) abort(404, 'Profil enseignant non trouvé.');

        // Classes enseignées (uniques)
        $matiereClasses = EnseignantMatiereClasse::query()->where('enseignant_id', $enseignant->id)
            ->with(['classe', 'matiere'])
            ->get();

        // Compter les élèves uniques dans toutes les classes
        $classesUniques = $matiereClasses->pluck('classe')->filter()->unique('id');
        $totalEleves = $classesUniques->sum(fn($c) => $c->eleves()->count());

        // Formater la liste des affectations Matière-Classe
        $assignments = $matiereClasses->map(function ($item) {
            $classe = $item->classe;
            $matiere = $item->matiere;
            if (!$classe || !$matiere) return null;

            return [
                'matiere_classe_id' => $item->id,
                'classe_id'         => $classe->id,
                'classe_nom'        => $classe->nom,
                'classe_nom_complet' => $classe->nom_complet,
                'matiere_id'        => $matiere->id,
                'matiere_nom'       => $matiere->nom,
                'nb_eleves'         => $classe->eleves()->count(),
            ];
        })->filter()->values();

        $stats = [
            'total_classes'      => $classesUniques->count(),
            'total_eleves'       => $totalEleves,
            'total_evaluations'  => Evaluation::query()->where('enseignant_id', $enseignant->id)->count(),
            'total_absences'     => Absence::query()->whereIn('matiere_id', $matiereClasses->pluck('matiere_id'))->count(),
        ];

        return response()->json([
            'enseignant' => [
                'id'     => $enseignant->id,
                'nom'    => $enseignant->nom,
                'prenom' => $enseignant->prenom,
            ],
            'assignments' => $assignments,
            'stats'   => $stats,
        ]);
    }
}