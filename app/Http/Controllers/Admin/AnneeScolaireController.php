<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnneeScolaire;
use Illuminate\Support\Facades\DB;

class AnneeScolaireController extends Controller
{
    /**
     * Affiche la liste des années scolaires avec filtres
     */
    public function index(Request $request)
    {
        $query = AnneeScolaire::query();

        // Filtre par statut (active/inactive)
        if ($request->filled('active')) {
            $query->where('active', $request->active === 'oui');
        }

        // Filtre par période
        if ($request->filled('date_debut_min')) {
            $query->where('date_debut', '>=', $request->date_debut_min);
        }
        if ($request->filled('date_debut_max')) {
            $query->where('date_debut', '<=', $request->date_debut_max);
        }

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('nom', 'like', "%{$request->search}%");
        }

        // Statistiques
        $stats = [
            'total' => AnneeScolaire::count(),
            'active' => AnneeScolaire::where('active', true)->count(),
            'inactive' => AnneeScolaire::where('active', false)->count(),
            'avec_inscriptions' => AnneeScolaire::has('inscriptions')->count(),
            'avec_evaluations' => AnneeScolaire::has('evaluations')->count(),
            'annee_en_cours' => AnneeScolaire::where('active', true)->first(),
        ];

        $anneeScolaires = $query->withCount(['inscriptions', 'evaluations', 'emploiDuTemps'])
            ->orderBy('date_debut', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.annee_scolaires.index', compact('anneeScolaires', 'stats'));
    }

    /**
     * Show the form for creating a new annee scolaire.
     */
    public function create()
    {
        return view('admin.annee_scolaires.create');
    }

    /**
     * Store a newly created annee scolaire in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:annee_scolaires,nom',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'active' => 'sometimes|boolean',
        ]);

        try {
            DB::beginTransaction();

            // Si on veut activer cette année, on désactive d'abord toutes les autres
            if ($request->boolean('active')) {
                AnneeScolaire::where('active', true)->update(['active' => false]);
                $validated['active'] = true;
            } else {
                $validated['active'] = false;
            }

            $anneeScolaire = AnneeScolaire::create($validated);

            DB::commit();

            return redirect()
                ->route('admin.annee_scolaires.show', $anneeScolaire)
                ->with('success', 'Année scolaire créée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified annee scolaire with its relations.
     */
    public function show(AnneeScolaire $anneeScolaire)
    {
        // Charger les relations avec comptage
        $anneeScolaire->load([
            'inscriptions' => function ($query) {
                $query->with(['eleve', 'classe'])->latest()->limit(10);
            },
            'evaluations' => function ($query) {
                $query->with(['classe', 'matiere'])->latest()->limit(10);
            },
            'emploiDuTemps' => function ($query) {
                $query->with(['classe', 'matiere', 'enseignant'])->latest()->limit(10);
            },
        ]);

        // Statistiques détaillées
        $stats = [
            'total_inscriptions' => $anneeScolaire->inscriptions()->count(),
            'total_evaluations' => $anneeScolaire->evaluations()->count(),
            'total_emplois' => $anneeScolaire->emploiDuTemps()->count(),
            'total_classes' => $anneeScolaire->classes()->count(),
            'inscriptions_par_mois' => $anneeScolaire->inscriptions()
                ->select(DB::raw('MONTH(created_at) as mois'), DB::raw('count(*) as total'))
                ->groupBy('mois')
                ->get(),
        ];

        return view('admin.annee_scolaires.show', compact('anneeScolaire', 'stats'));
    }

    /**
     * Show the form for editing the specified annee scolaire.
     */
    public function edit(AnneeScolaire $anneeScolaire)
    {
        return view('admin.annee_scolaires.edit', compact('anneeScolaire'));
    }

    /**
     * Update the specified annee scolaire in storage.
     */
    public function update(Request $request, AnneeScolaire $anneeScolaire)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:annee_scolaires,nom,' . $anneeScolaire->id,
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'active' => 'sometimes|boolean',
        ]);

        try {
            DB::beginTransaction();

            // Gestion de l'activation
            if ($request->boolean('active') && !$anneeScolaire->active) {
                // Si on veut activer cette année, on désactive toutes les autres
                AnneeScolaire::where('active', true)
                    ->where('id', '!=', $anneeScolaire->id)
                    ->update(['active' => false]);
                $validated['active'] = true;
            } elseif (!$request->boolean('active') && $anneeScolaire->active) {
                // Si on désactive l'année active, on vérifie qu'il y a une autre année active
                $autreActive = AnneeScolaire::where('active', true)
                    ->where('id', '!=', $anneeScolaire->id)
                    ->exists();
                
                if (!$autreActive) {
                    return back()
                        ->withInput()
                        ->with('error', 'Vous ne pouvez pas désactiver la seule année scolaire active.');
                }
                $validated['active'] = false;
            }

            $anneeScolaire->update($validated);

            DB::commit();

            return redirect()
                ->route('admin.annee_scolaires.show', $anneeScolaire)
                ->with('success', 'Année scolaire mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * Activate the specified annee scolaire.
     */
    public function activate(AnneeScolaire $anneeScolaire)
    {
        try {
            DB::beginTransaction();

            // Vérifier si l'année est déjà active
            if ($anneeScolaire->active) {
                return redirect()
                    ->route('admin.annee_scolaires.index')
                    ->with('info', 'Cette année scolaire est déjà active.');
            }

            // Désactiver toutes les autres années
            AnneeScolaire::where('active', true)->update(['active' => false]);
            
            // Activer l'année sélectionnée
            $anneeScolaire->update(['active' => true]);

            DB::commit();

            return redirect()
                ->route('admin.annee_scolaires.index')
                ->with('success', 'Année scolaire activée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->with('error', 'Une erreur est survenue lors de l\'activation : ' . $e->getMessage());
        }
    }

    /**
     * Désactiver une année scolaire
     */
    public function deactivate(AnneeScolaire $anneeScolaire)
    {
        try {
            DB::beginTransaction();

            // Vérifier si c'est la seule année active
            $activeCount = AnneeScolaire::where('active', true)->count();
            
            if ($activeCount <= 1 && $anneeScolaire->active) {
                return redirect()
                    ->route('admin.annee_scolaires.index')
                    ->with('error', 'Impossible de désactiver la seule année scolaire active.');
            }

            $anneeScolaire->update(['active' => false]);

            DB::commit();

            return redirect()
                ->route('admin.annee_scolaires.index')
                ->with('success', 'Année scolaire désactivée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->with('error', 'Une erreur est survenue lors de la désactivation : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified annee scolaire from storage.
     */
    public function destroy(AnneeScolaire $anneeScolaire)
    {
        try {
            DB::beginTransaction();

            // Vérifier si l'année a des dépendances
            $dependencies = [];

            if ($anneeScolaire->inscriptions()->exists()) {
                $dependencies[] = 'inscriptions';
            }
            if ($anneeScolaire->evaluations()->exists()) {
                $dependencies[] = 'évaluations';
            }
            if ($anneeScolaire->emploiDuTemps()->exists()) {
                $dependencies[] = 'emplois du temps';
            }
            if ($anneeScolaire->classes()->exists()) {
                $dependencies[] = 'classes';
            }

            if (!empty($dependencies)) {
                $liste = implode(', ', $dependencies);
                return redirect()
                    ->route('admin.annee_scolaires.index')
                    ->with('error', "Impossible de supprimer cette année scolaire car elle est utilisée dans : {$liste}.");
            }

            // Vérifier si c'est l'année active
            if ($anneeScolaire->active) {
                return redirect()
                    ->route('admin.annee_scolaires.index')
                    ->with('error', 'Impossible de supprimer l\'année scolaire active. Veuillez d\'abord en activer une autre.');
            }

            $anneeScolaire->delete();

            DB::commit();

            return redirect()
                ->route('admin.annee_scolaires.index')
                ->with('success', 'Année scolaire supprimée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->with('error', 'Une erreur est survenue lors de la suppression : ' . $e->getMessage());
        }
    }

    /**
     * API : Vérifier si les dates sont valides
     */
    public function checkDates(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'ignore_id' => 'nullable|exists:annee_scolaires,id',
        ]);

        $query = AnneeScolaire::where(function ($q) use ($request) {
            $q->whereBetween('date_debut', [$request->date_debut, $request->date_fin])
              ->orWhereBetween('date_fin', [$request->date_debut, $request->date_fin])
              ->orWhere(function ($q2) use ($request) {
                  $q2->where('date_debut', '<=', $request->date_debut)
                     ->where('date_fin', '>=', $request->date_fin);
              });
        });

        if ($request->filled('ignore_id')) {
            $query->where('id', '!=', $request->ignore_id);
        }

        $overlap = $query->exists();

        return response()->json([
            'overlap' => $overlap,
            'message' => $overlap ? 'Cette période chevauche une année scolaire existante' : 'Période disponible'
        ]);
    }

    /**
     * API : Obtenir les statistiques rapides
     */
    public function getQuickStats()
    {
        $stats = [
            'total' => AnneeScolaire::count(),
            'active' => AnneeScolaire::where('active', true)->count(),
            'inactive' => AnneeScolaire::where('active', false)->count(),
            'avec_inscriptions' => AnneeScolaire::has('inscriptions')->count(),
            'total_inscriptions' => \App\Models\Inscription::count(),
            'total_evaluations' => \App\Models\Evaluation::count(),
        ];

        return response()->json($stats);
    }

    /**
     * API : Obtenir l'année active
     */
    public function getActive()
    {
        $active = AnneeScolaire::where('active', true)->first();
        
        return response()->json($active);
    }
}