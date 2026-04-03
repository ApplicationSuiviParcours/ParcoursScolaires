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
        $user = Auth::user();
        if (!$user->isEnseignant()) abort(403);

        $enseignant = $user->enseignant;
        if (!$enseignant) abort(404, 'Profil enseignant non trouvé.');

        // Classes enseignées (uniques)
        $matiereClasses = EnseignantMatiereClasse::where('enseignant_id', $enseignant->id)
            ->with(['classe', 'matiere'])
            ->get();

        // Compter les élèves uniques dans toutes les classes
        $classesUniques = $matiereClasses->pluck('classe')->filter()->unique('id');
        $totalEleves = $classesUniques->sum(fn($c) => $c->eleves()->count());

        // Formater la liste des classes avec le nombre d'élèves et la matière
        $classesList = $matiereClasses->groupBy('classe_id')->map(function ($items) use ($totalEleves) {
            $classe = $items->first()->classe;
            if (!$classe) return null;

            $matieres = $items->pluck('matiere.nom')->filter()->implode(', ');
            return [
                'id'        => $classe->id,
                'nom'       => $classe->nom ?? $classe->nom_complet,
                'matiere'   => $matieres,
                'nb_eleves' => $classe->eleves()->count(),
            ];
        })->filter()->values();

        $stats = [
            'total_classes'      => $classesUniques->count(),
            'total_eleves'       => $totalEleves,
            'total_evaluations'  => Evaluation::whereHas(
                'matiereClasse.enseignant',
                fn($q) => $q->where('id', $enseignant->id)
            )->count(),
            'total_absences'     => Absence::whereHas(
                'matiere.matiereClasses.enseignant',
                fn($q) => $q->where('id', $enseignant->id)
            )->count(),
        ];

        return response()->json([
            'enseignant' => [
                'id'     => $enseignant->id,
                'nom'    => $enseignant->nom,
                'prenom' => $enseignant->prenom,
            ],
            'classes' => $classesList,
            'stats'   => $stats,
        ]);
    }
}