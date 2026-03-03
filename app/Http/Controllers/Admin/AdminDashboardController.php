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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Affiche le tableau de bord admin avec statistiques et graphiques
     */
    public function stats()
    {
        // Données pour les cartes de statistiques
        $stats = [
            'totalEleves' => Eleve::count(),
            'totalEnseignants' => Enseignant::count(),
            'totalClasses' => Classe::count(),
            'totalMatieres' => Matiere::count(),
        ];

        // Inscriptions par mois (12 derniers mois)
        $inscriptionsByMonth = $this->getInscriptionsByMonth();
        
        // Élèves par classe
        $studentsByClass = $this->getStudentsByClass();
        
        // Moyennes par trimestre
        $gradesByTrimester = $this->getGradesByTrimester();
        
        // Absences par mois
        $absencesByMonth = $this->getAbsencesByMonth();

        return view('admin.dashboard-stats', compact(
            'stats',
            'inscriptionsByMonth',
            'studentsByClass',
            'gradesByTrimester',
            'absencesByMonth'
        ));
    }

    /**
     * Obtenir les inscriptions par mois
     */
    private function getInscriptionsByMonth()
    {
        $months = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            $year = $date->format('Y');
            $months[] = $monthName . ' ' . $year;
            
            $count = Inscription::whereYear('date_inscription', $date->year)
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
    private function getStudentsByClass()
    {
        $classes = Classe::withCount('inscriptions')->get();
        
        return [
            'labels' => $classes->pluck('nom')->toArray(),
            'data' => $classes->pluck('inscriptions_count')->toArray()
        ];
    }

    /**
     * Obtenir les moyennes par trimestre
     */
    private function getGradesByTrimester()
    {
        $bulletins = Bulletin::select('periode')
            ->selectRaw('AVG(moyenne_generale) as avg_grade')
            ->groupBy('periode')
            ->get();
        
        $labels = [];
        $data = [];
        
        // Ordre des trimestres
        $trimesterOrder = ['Trimestre 1', 'Trimestre 2', 'Trimestre 3', 'Semestre 1', 'Semestre 2'];
        
        foreach ($trimesterOrder as $trimester) {
            $bulletin = $bulletins->firstWhere('periode', $trimester);
            $labels[] = $trimester ?? 'N/A';
            $data[] = $bulletin ? round($bulletin->avg_grade, 2) : 0;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Obtenir les absences par mois
     */
    private function getAbsencesByMonth()
    {
        $months = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            $year = $date->format('Y');
            $months[] = $monthName . ' ' . $year;
            
            // Supposons que les absences ont un champ 'date_absence'
            $count = Absence::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }
        
        return [
            'labels' => $months,
            'data' => $data
        ];
    }
}
