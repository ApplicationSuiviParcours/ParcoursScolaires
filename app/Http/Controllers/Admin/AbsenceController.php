<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use App\Models\Inscription;
use Illuminate\Support\Facades\DB;

class AbsenceController extends Controller
{
    /**
     * Affiche la liste des absences avec filtres
     */
    public function index(Request $request)
    {
        $query = Absence::with(['eleve', 'matiere', 'anneeScolaire']);

        // Filtre par année scolaire
        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        }

        // Filtre par classe
        if ($request->filled('classe_id')) {
            $eleveIds = Inscription::where('classe_id', $request->classe_id)
                ->where('statut', true)
                ->pluck('eleve_id');
            $query->whereIn('eleve_id', $eleveIds);
        }

        // Filtre par élève
        if ($request->filled('eleve_id')) {
            $query->where('eleve_id', $request->eleve_id);
        }

        // Filtre par matière
        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        // Filtre par statut (justifiée/non justifiée)
        if ($request->filled('justifiee')) {
            $query->where('justifiee', $request->justifiee === 'oui');
        }

        // Filtre par période
        if ($request->filled('date_debut')) {
            $query->whereDate('date_absence', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('date_absence', '<=', $request->date_fin);
        }

        // Statistiques
        $stats = [
            'total' => Absence::count(),
            'justifiees' => Absence::where('justifiee', true)->count(),
            'non_justifiees' => Absence::where('justifiee', false)->count(),
            'aujourd_hui' => Absence::whereDate('date_absence', now()->toDateString())->count(),
            'ce_mois' => Absence::whereMonth('date_absence', now()->month)
                ->whereYear('date_absence', now()->year)
                ->count(),
        ];

        $absences = $query->orderBy('date_absence', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->paginate(20)
                         ->withQueryString();

        // Données pour les filtres
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();

        return view('admin.absences.index', compact(
            'absences', 
            'anneeScolaires', 
            'classes', 
            'matieres',
            'stats'
        ));
    }

    /**
     * Affiche les absences par classe (tableau récapitulatif)
     */
    public function byClasse(Request $request)
    {
        $classeId = $request->get('classe_id');
        $anneeScolaireId = $request->get('annee_scolaire_id');
        
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();
        
        $eleves = [];
        $absencesParEleve = [];
        $stats = [];
        
        if ($classeId && $anneeScolaireId) {
            // Récupérer les élèves de la classe
            $eleveIds = Inscription::where('classe_id', $classeId)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->where('statut', true)
                ->pluck('eleve_id');
            
            $eleves = Eleve::whereIn('id', $eleveIds)
                ->orderBy('nom')
                ->orderBy('prenom')
                ->get();
            
            // Statistiques globales pour la classe
            $totalAbsences = Absence::whereIn('eleve_id', $eleveIds)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->count();
            
            $absencesJustifiees = Absence::whereIn('eleve_id', $eleveIds)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->where('justifiee', true)
                ->count();
            
            // Compter les absences par élève
            foreach ($eleves as $eleve) {
                $absencesParEleve[$eleve->id] = [
                    'total' => Absence::where('eleve_id', $eleve->id)
                        ->where('annee_scolaire_id', $anneeScolaireId)
                        ->count(),
                    'justifiees' => Absence::where('eleve_id', $eleve->id)
                        ->where('annee_scolaire_id', $anneeScolaireId)
                        ->where('justifiee', true)
                        ->count(),
                    'non_justifiees' => Absence::where('eleve_id', $eleve->id)
                        ->where('annee_scolaire_id', $anneeScolaireId)
                        ->where('justifiee', false)
                        ->count(),
                ];
            }
            
            $stats = [
                'total_eleves' => $eleves->count(),
                'total_absences' => $totalAbsences,
                'moyenne_par_eleve' => $eleves->count() > 0 ? round($totalAbsences / $eleves->count(), 2) : 0,
                'taux_justification' => $totalAbsences > 0 ? round(($absencesJustifiees / $totalAbsences) * 100, 2) : 0,
            ];
        }

        return view('admin.absences.by-classe', compact(
            'classes', 
            'anneeScolaires', 
            'eleves',
            'absencesParEleve', 
            'stats',
            'classeId', 
            'anneeScolaireId'
        ));
    }

    /**
     * Affiche les absences d'un élève spécifique
     */
    public function byEleve(Request $request, Eleve $eleve)
    {
        $anneeScolaireId = $request->get('annee_scolaire_id');
        
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        
        $query = Absence::where('eleve_id', $eleve->id)
            ->with(['matiere', 'anneeScolaire']);
        
        if ($anneeScolaireId) {
            $query->where('annee_scolaire_id', $anneeScolaireId);
        }
        
        $absences = $query->orderBy('date_absence', 'desc')->get();
        
        // Statistiques pour l'élève
        $stats = [
            'total' => $absences->count(),
            'justifiees' => $absences->where('justifiee', true)->count(),
            'non_justifiees' => $absences->where('justifiee', false)->count(),
            'par_matiere' => $absences->groupBy('matiere_id')
                ->map(function($items, $matiereId) {
                    return [
                        'matiere' => $items->first()->matiere,
                        'total' => $items->count(),
                        'justifiees' => $items->where('justifiee', true)->count(),
                    ];
                })->values(),
        ];

        return view('admin.absences.by-eleve', compact(
            'eleve', 
            'absences', 
            'anneeScolaires', 
            'anneeScolaireId',
            'stats'
        ));
    }

    /**
     * Affiche le formulaire de création d'une absence
     */
    public function create()
    {
        $eleves = Eleve::orderBy('nom')->orderBy('prenom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        
        return view('admin.absences.create', compact('eleves', 'matieres', 'anneeScolaires'));
    }

    /**
     * Enregistre une nouvelle absence
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'date_absence' => 'required|date',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i|after:heure_debut',
            'motif' => 'nullable|string|max:500',
            'justifiee' => 'sometimes|boolean',
        ]);

        // Valeur par défaut pour justifiee
        $validated['justifiee'] = $validated['justifiee'] ?? false;

        try {
            Absence::create($validated);

            return redirect()
                ->route('admin.absences.index')
                ->with('success', 'Absence enregistrée avec succès.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'enregistrement.');
        }
    }

    /**
     * Affiche les détails d'une absence
     */
    public function show(Absence $absence)
    {
        $absence->load(['eleve', 'matiere', 'anneeScolaire']);
        
        return view('admin.absences.show', compact('absence'));
    }

    /**
     * Affiche le formulaire d'édition d'une absence
     */
    public function edit(Absence $absence)
    {
        $eleves = Eleve::orderBy('nom')->orderBy('prenom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        
        return view('admin.absences.edit', compact('absence', 'eleves', 'matieres', 'anneeScolaires'));
    }

    /**
     * Met à jour une absence
     */
    public function update(Request $request, Absence $absence)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'date_absence' => 'required|date',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i|after:heure_debut',
            'motif' => 'nullable|string|max:500',
            'justifiee' => 'required|boolean',
        ]);

        try {
            $absence->update($validated);

            return redirect()
                ->route('admin.absences.show', $absence)
                ->with('success', 'Absence mise à jour avec succès.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }

    /**
     * Justifier une absence (méthode simplifiée)
     */
    public function justify(Request $request, Absence $absence)
    {
        $request->validate([
            'motif' => 'required|string|max:500',
        ]);

        try {
            $absence->update([
                'justifiee' => true,
                'motif' => $request->motif,
            ]);

            return redirect()
                ->back()
                ->with('success', 'Absence justifiée avec succès.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Une erreur est survenue lors de la justification.');
        }
    }

    /**
     * Supprimer une absence
     */
    public function destroy(Absence $absence)
    {
        try {
            $absence->delete();

            return redirect()
                ->route('admin.absences.index')
                ->with('success', 'Absence supprimée avec succès.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    /**
     * API : Obtenir les statistiques rapides
     */
    public function getQuickStats()
    {
        $stats = [
            'total' => Absence::count(),
            'justifiees' => Absence::where('justifiee', true)->count(),
            'non_justifiees' => Absence::where('justifiee', false)->count(),
            'aujourd_hui' => Absence::whereDate('date_absence', now()->toDateString())->count(),
            'ce_mois' => Absence::whereMonth('date_absence', now()->month)
                ->whereYear('date_absence', now()->year)
                ->count(),
            'taux_justification' => $this->calculerTauxJustification(),
        ];

        return response()->json($stats);
    }

    /**
     * Calcule le taux de justification global
     */
    private function calculerTauxJustification(): float
    {
        $total = Absence::count();
        if ($total === 0) {
            return 0;
        }
        
        $justifiees = Absence::where('justifiee', true)->count();
        return round(($justifiees / $total) * 100, 2);
    }

    /**
     * API : Obtenir les absences pour un élève
     */
    public function getAbsencesEleve(Eleve $eleve, Request $request)
    {
        $query = Absence::where('eleve_id', $eleve->id)
            ->with(['matiere']);

        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        }

        if ($request->filled('justifiee')) {
            $query->where('justifiee', $request->justifiee === 'oui');
        }

        $absences = $query->orderBy('date_absence', 'desc')->get();

        return response()->json($absences);
    }
}