<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Inscription;
use App\Models\Bulletin;
use App\Models\Absence;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Affiche le tableau de bord admin avec statistiques et graphiques
     */
    public function stats()
    {
        // Récupérer l'année scolaire active
        $activeYear = AnneeScolaire::active()->first() ?? AnneeScolaire::latest()->first();
        
        if (!$activeYear) {
            // Fallback si aucune année n'existe du tout
            return view('admin.dashboard-stats', [
                'stats' => ['totalEleves' => 0, 'totalEnseignants' => 0, 'totalClasses' => 0, 'totalMatieres' => 0],
                'inscriptionsByMonth' => ['labels' => [], 'data' => []],
                'studentsByClass' => ['labels' => [], 'data' => []],
                'gradesByTrimester' => ['labels' => [], 'data' => []],
                'absencesByMonth' => ['labels' => [], 'data' => []],
                'activeYear' => null
            ]);
        }

        // Données pour les cartes de statistiques
        $stats = [
            'totalEleves' => Inscription::where('annee_scolaire_id', $activeYear->id)->distinct('eleve_id')->count(),
            'totalEnseignants' => Enseignant::whereHas('enseignantMatiereClasses', fn($q) => $q->where('annee_scolaire_id', $activeYear->id))->distinct()->count() ?: Enseignant::count(),
            'totalClasses' => Classe::where('annee_scolaire_id', $activeYear->id)->count(),
            'totalMatieres' => Matiere::count(), // Les matières sont généralement globales, mais on pourrait filtrer par celles enseignées cette année
        ];

        // Inscriptions par mois (filtrées par année scolaire)
        $inscriptionsByMonth = $this->getInscriptionsByMonth($activeYear);
        
        // Élèves par classe (filtrés par année scolaire)
        $studentsByClass = $this->getStudentsByClass($activeYear);
        
        // Moyennes par trimestre (filtrées par année scolaire)
        $gradesByTrimester = $this->getGradesByTrimester($activeYear);
        
        // Absences par mois (filtrées par année scolaire)
        $absencesByMonth = $this->getAbsencesByMonth($activeYear);

        // Inscriptions récentes
        $recentInscriptions = Inscription::where('annee_scolaire_id', $activeYear->id)
            ->with(['eleve', 'classe'])
            ->latest()
            ->limit(5)
            ->get();

        // Évaluations à venir
        $upcomingEvaluations = \App\Models\Evaluation::where('annee_scolaire_id', $activeYear->id)
            ->upcoming()
            ->with(['classe', 'matiere'])
            ->orderBy('date_evaluation', 'asc')
            ->limit(5)
            ->get();

        return view('admin.dashboard-stats', compact(
            'stats',
            'inscriptionsByMonth',
            'studentsByClass',
            'gradesByTrimester',
            'absencesByMonth',
            'recentInscriptions',
            'upcomingEvaluations',
            'activeYear'
        ));
    }

    /**
     * Obtenir les inscriptions par mois
     */
    private function getInscriptionsByMonth($activeYear)
    {
        $months = [];
        $data = [];
        
        // On remonte sur les 10 derniers mois ou la période de l'année scolaire
        for ($i = 9; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->translatedFormat('M');
            $year = $date->format('Y');
            $months[] = $monthName . ' ' . $year;
            
            $count = Inscription::where('annee_scolaire_id', $activeYear->id)
                ->whereYear('date_inscription', $date->year)
                ->whereMonth('date_inscription', $date->month)
                ->count();
            $data[] = $count;
        }
        
        return [
            'labels' => $months,
            'data' => $data
        ];
    }

    /**
     * Obtenir les élèves par classe
     */
    private function getStudentsByClass($activeYear)
    {
        $classes = Classe::where('annee_scolaire_id', $activeYear->id)
            ->withCount(['inscriptions' => function($query) use ($activeYear) {
                $query->where('annee_scolaire_id', $activeYear->id);
            }])->get();
        
        return [
            'labels' => $classes->pluck('nom')->toArray(),
            'data' => $classes->pluck('inscriptions_count')->toArray()
        ];
    }

    /**
     * Obtenir les moyennes par trimestre
     */
    private function getGradesByTrimester($activeYear)
    {
        $bulletins = Bulletin::where('annee_scolaire_id', $activeYear->id)
            ->select('periode')
            ->selectRaw('AVG(moyenne_generale) as avg_grade')
            ->groupBy('periode')
            ->get();
        
        $labels = [];
        $data = [];
        
        // Ordre des trimestres
        $trimesterOrder = ['Trimestre 1', 'Trimestre 2', 'Trimestre 3'];
        
        foreach ($trimesterOrder as $trimester) {
            $bulletin = $bulletins->firstWhere('periode', $trimester);
            if ($bulletin || in_array($trimester, ['Trimestre 1', 'Trimestre 2', 'Trimestre 3'])) {
                $labels[] = $trimester;
                $data[] = $bulletin ? round($bulletin->avg_grade, 2) : 0;
            }
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Obtenir les absences par mois
     */
    private function getAbsencesByMonth($activeYear)
    {
        $months = [];
        $data = [];
        
        for ($i = 9; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->translatedFormat('M');
            $year = $date->format('Y');
            $months[] = $monthName . ' ' . $year;
            
            $count = Absence::where('annee_scolaire_id', $activeYear->id)
                ->whereYear('date_absence', $date->year)
                ->whereMonth('date_absence', $date->month)
                ->count();
            $data[] = $count;
        }
        
        return [
            'labels' => $months,
            'data' => $data
        ];
    }

}
