<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enseignant;
use App\Models\EnseignantMatiereClasse;
use App\Models\Evaluation;
use App\Models\Absence;
use App\Models\Note;
use App\Models\Inscription;

class EnseignantController extends Controller
{
    /**
     * Middleware pour s'assurer que l'utilisateur est connecté et est un enseignant
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Récupère l'enseignant connecté
     */
    private function getEnseignantConnecte()
    {
        $user = Auth::user();
        
        if (!$user) {
            return null;
        }

        return Enseignant::where('user_id', $user->id)->first();
    }

    /**
     * Affiche le tableau de bord de l'enseignant
     */
    public function dashboard()
    {
        $enseignant = $this->getEnseignantConnecte();

        if (!$enseignant) {
            return redirect('/')
                ->with('error', 'Aucun profil enseignant associé à votre compte. Veuillez contacter l\'administrateur.');
        }

        $classesCount = EnseignantMatiereClasse::where('enseignant_id', $enseignant->id)
            ->distinct('classe_id')
            ->count('classe_id');

        $evaluationsCount = Evaluation::where('enseignant_id', $enseignant->id)->count();

        $evaluationsAVenir = Evaluation::where('enseignant_id', $enseignant->id)
            ->where('date_evaluation', '>=', now())
            ->count();

        $classeIds = EnseignantMatiereClasse::where('enseignant_id', $enseignant->id)
            ->distinct('classe_id')
            ->pluck('classe_id');

        $eleveIds = Inscription::whereIn('classe_id', $classeIds)
            ->where('statut', true)
            ->pluck('eleve_id');

        $absencesCount = Absence::whereIn('eleve_id', $eleveIds)
            ->whereDate('date_absence', now()->toDateString())
            ->count();

        $dernieresEvaluations = Evaluation::where('enseignant_id', $enseignant->id)
            ->with(['classe', 'matiere'])
            ->orderBy('date_evaluation', 'desc')
            ->limit(5)
            ->get();

        return view('enseignant.dashboard', compact(
            'enseignant',
            'classesCount',
            'evaluationsCount',
            'evaluationsAVenir',
            'absencesCount',
            'dernieresEvaluations'
        ));
    }

    /**
     * Affiche les classes de l'enseignant
     */
    public function mesClasses()
    {
        $enseignant = $this->getEnseignantConnecte();

        if (!$enseignant) {
            return redirect('/')
                ->with('error', 'Aucun profil enseignant associé à votre compte.');
        }

        $classes = EnseignantMatiereClasse::where('enseignant_id', $enseignant->id)
            ->with(['classe', 'matiere', 'anneeScolaire'])
            ->get();

        return view('enseignant.classes', compact('classes', 'enseignant'));
    }

    /**
     * Affiche les évaluations de l'enseignant
     */
    public function evaluations()
    {
        $enseignant = $this->getEnseignantConnecte();

        if (!$enseignant) {
            return redirect('/')
                ->with('error', 'Aucun profil enseignant associé à votre compte.');
        }

        $evaluations = Evaluation::where('enseignant_id', $enseignant->id)
            ->with(['classe', 'matiere', 'anneeScolaire'])
            ->orderBy('date_evaluation', 'desc')
            ->get();

        return view('enseignant.evaluations', compact('evaluations', 'enseignant'));
    }

    /**
     * Affiche le formulaire de saisie des notes
     */
    public function saisirNotes()
    {
        $enseignant = $this->getEnseignantConnecte();

        if (!$enseignant) {
            return redirect('/')
                ->with('error', 'Aucun profil enseignant associé à votre compte.');
        }

        $classes = EnseignantMatiereClasse::where('enseignant_id', $enseignant->id)
            ->with(['classe', 'matiere'])
            ->get();

        return view('enseignant.notes', compact('classes', 'enseignant'));
    }

    /**
     * Affiche les absences de l'enseignant
     */
    public function absences()
    {
        $enseignant = $this->getEnseignantConnecte();

        if (!$enseignant) {
            return redirect('/')
                ->with('error', 'Aucun profil enseignant associé à votre compte.');
        }

        $absences = Absence::whereHas('matiere.enseignantMatiereClasses', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })
            ->with(['eleve', 'matiere'])
            ->orderBy('date_absence', 'desc')
            ->get();

        return view('enseignant.absences', compact('absences', 'enseignant'));
    }

    /**
     * Affiche le profil de l'enseignant
     */
    public function profil()
    {
        $enseignant = $this->getEnseignantConnecte();

        if (!$enseignant) {
            return redirect('/')
                ->with('error', 'Aucun profil enseignant associé à votre compte.');
        }

        return view('enseignant.profil', compact('enseignant'));
    }
}
