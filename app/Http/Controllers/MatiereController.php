<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\Enseignant;

class MatiereController extends Controller
{
    /**
     * Affiche la liste des matières avec filtres et statistiques
     */
    public function index(Request $request)
    {
        $query = Matiere::query();

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtre par coefficient
        if ($request->filled('coefficient_min')) {
            $query->where('coefficient', '>=', $request->coefficient_min);
        }
        if ($request->filled('coefficient_max')) {
            $query->where('coefficient', '<=', $request->coefficient_max);
        }

        // Tri
        $orderBy = $request->get('order_by', 'nom');
        $orderDir = $request->get('order_dir', 'asc');
        $query->orderBy($orderBy, $orderDir);

        $matieres = $query->withCount(['evaluations', 'absences', 'classeMatieres'])
                         ->paginate(15)
                         ->withQueryString();

        // Statistiques
        $stats = [
            'total' => Matiere::count(),
            'coefficient_moyen' => round(Matiere::avg('coefficient') ?? 0, 1),
            'coefficient_max' => Matiere::max('coefficient') ?? 0,
            'coefficient_min' => Matiere::min('coefficient') ?? 0,
            'avec_evaluations' => Matiere::has('evaluations')->count(),
            'avec_absences' => Matiere::has('absences')->count(),
        ];

        return view('admin.matieres.index', compact('matieres', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.matieres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:matieres,code|regex:/^[A-Z0-9]+$/',
            'description' => 'nullable|string|max:1000',
            'coefficient' => 'required|integer|min:1|max:10',
        ], [
            'code.regex' => 'Le code doit contenir uniquement des lettres majuscules et des chiffres.',
            'coefficient.max' => 'Le coefficient ne peut pas dépasser 10.',
        ]);

        try {
            $matiere = Matiere::create([
                'nom' => $request->nom,
                'code' => strtoupper($request->code),
                'description' => $request->description,
                'coefficient' => $request->coefficient,
            ]);

            return redirect()
                ->route('admin.matieres.show', $matiere)
                ->with('success', 'Matière créée avec succès.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de la matière.');
        }
    }

    /**
     * Display the specified resource with its relations.
     */
    public function show(Matiere $matiere)
    {
        // Charger les relations
        $matiere->load([
            'classeMatieres' => function($q) {
                $q->with(['classe'])
                  ->orderBy('created_at', 'desc');
            },
            'evaluations' => function($q) {
                $q->with(['classe', 'notes'])
                  ->latest()
                  ->limit(10);
            },
            'absences' => function($q) {
                $q->with([
                    'eleve' => function($query) {
                        $query->with(['inscriptions' => function($q) {
                            $q->with(['classe'])
                              ->where('statut', true)
                              ->latest();
                        }]);
                    }
                ])
                ->latest()
                ->limit(10);
            },
            'emploiDuTemps' => function($q) {
                $q->with(['classe', 'enseignant'])
                  ->orderBy('jour')
                  ->orderBy('heure_debut');
            },
            'enseignantMatiereClasses' => function($q) {
                $q->with(['enseignant', 'classe'])
                  ->orderBy('created_at', 'desc');
            }
        ]);

        // Statistiques détaillées
        $stats = [
            'total_evaluations' => $matiere->evaluations()->count(),
            'total_absences' => $matiere->absences()->count(),
            'total_classes' => $matiere->classeMatieres()->count(),
            'total_enseignants' => $matiere->enseignantMatiereClasses()
                ->distinct('enseignant_id')
                ->count('enseignant_id'),
            'total_heures_cours' => $matiere->emploiDuTemps()->count(),
            'moyenne_notes' => $this->calculerMoyenneNotes($matiere),
            'note_min' => $this->calculerNoteMin($matiere),
            'note_max' => $this->calculerNoteMax($matiere),
        ];

        // Classes associées
        $classes = $matiere->classeMatieres()
            ->with('classe')
            ->get()
            ->pluck('classe')
            ->unique('id')
            ->values();

        // Enseignants associés (via EnseignantMatiereClasse)
        $enseignants = $matiere->enseignantMatiereClasses()
            ->with('enseignant')
            ->get()
            ->pluck('enseignant')
            ->unique('id')
            ->values();

        return view('admin.matieres.show', compact(
            'matiere', 
            'stats', 
            'classes', 
            'enseignants'
        ));
    }

    /**
     * Calcule la moyenne des notes pour une matière
     */
    private function calculerMoyenneNotes(Matiere $matiere): float
    {
        $notes = $matiere->evaluations()
            ->with('notes')
            ->get()
            ->pluck('notes')
            ->flatten();

        if ($notes->isEmpty()) {
            return 0;
        }

        return round($notes->avg('note') ?? 0, 2);
    }

    /**
     * Calcule la note minimale pour une matière
     */
    private function calculerNoteMin(Matiere $matiere): float
    {
        $notes = $matiere->evaluations()
            ->with('notes')
            ->get()
            ->pluck('notes')
            ->flatten();

        return round($notes->min('note') ?? 0, 2);
    }

    /**
     * Calcule la note maximale pour une matière
     */
    private function calculerNoteMax(Matiere $matiere): float
    {
        $notes = $matiere->evaluations()
            ->with('notes')
            ->get()
            ->pluck('notes')
            ->flatten();

        return round($notes->max('note') ?? 0, 2);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matiere $matiere)
    {
        // Calculer les statistiques pour la zone de danger
        $stats = [
            'total_evaluations' => $matiere->evaluations()->count(),
            'total_absences' => $matiere->absences()->count(),
            'total_classes' => $matiere->classeMatieres()->count(),
            'total_enseignants' => $matiere->enseignantMatiereClasses()
                ->distinct('enseignant_id')
                ->count('enseignant_id'),
            'total_heures_cours' => $matiere->emploiDuTemps()->count(),
        ];

        return view('admin.matieres.edit', compact('matiere', 'stats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matiere $matiere)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:matieres,code,' . $matiere->id . '|regex:/^[A-Z0-9]+$/',
            'description' => 'nullable|string|max:1000',
            'coefficient' => 'required|integer|min:1|max:10',
        ], [
            'code.regex' => 'Le code doit contenir uniquement des lettres majuscules et des chiffres.',
            'coefficient.max' => 'Le coefficient ne peut pas dépasser 10.',
        ]);

        try {
            $matiere->update([
                'nom' => $request->nom,
                'code' => strtoupper($request->code),
                'description' => $request->description,
                'coefficient' => $request->coefficient,
            ]);

            return redirect()
                ->route('admin.matieres.show', $matiere)
                ->with('success', 'Matière mise à jour avec succès.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour de la matière.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matiere $matiere)
    {
        try {
            // Compter les dépendances
            $countEvaluations = $matiere->evaluations()->count();
            $countAbsences = $matiere->absences()->count();
            $countClasses = $matiere->classeMatieres()->count();
            $countEmplois = $matiere->emploiDuTemps()->count();
            $countEnseignants = $matiere->enseignantMatiereClasses()->count();

            // Afficher les comptes dans la session pour déboguer
            session()->flash('debug', [
                'evaluations' => $countEvaluations,
                'absences' => $countAbsences,
                'classes' => $countClasses,
                'emplois' => $countEmplois,
                'enseignants' => $countEnseignants,
            ]);

            if ($countEvaluations > 0 || $countAbsences > 0 || $countClasses > 0 || $countEmplois > 0 || $countEnseignants > 0) {
                return back()->with('error', 'Cette matière a des dépendances et ne peut pas être supprimée.');
            }

            $matiere->delete();

            return redirect()
                ->route('admin.matieres.index')
                ->with('success', 'Matière supprimée avec succès.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erreur : ' . $e->getMessage());
        }
    }
    /**
     * Dupliquer une matière
     */
    public function duplicate(Matiere $matiere)
    {
        try {
            $nouvelleMatiere = $matiere->replicate();
            $nouvelleMatiere->code = $matiere->code . '_COPY';
            $nouvelleMatiere->nom = $matiere->nom . ' (copie)';
            $nouvelleMatiere->save();

            return redirect()
                ->route('admin.matieres.edit', $nouvelleMatiere)
                ->with('success', 'Matière dupliquée avec succès. Veuillez modifier le code.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Une erreur est survenue lors de la duplication.');
        }
    }

    /**
     * Export des matières
     */
    public function export(Request $request)
    {
        try {
            $matieres = Matiere::orderBy('nom')->get();

            // Logique d'export (CSV, Excel, PDF)
            // À implémenter selon les besoins

            return redirect()
                ->route('admin.matieres.index')
                ->with('success', 'Export en cours de développement.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Une erreur est survenue lors de l\'export.');
        }
    }
}