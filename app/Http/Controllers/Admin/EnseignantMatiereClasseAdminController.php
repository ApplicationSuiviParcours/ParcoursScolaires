<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnseignantMatiereClasse;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use Illuminate\Support\Facades\DB;

class EnseignantMatiereClasseAdminController extends Controller
{
    /**
     * Affiche la liste des affectations enseignant-matière-classe
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $enseignant_id = $request->get('enseignant_id');
        $classe_id = $request->get('classe_id');
        $matiere_id = $request->get('matiere_id');
        $annee_scolaire_id = $request->get('annee_scolaire_id');

        $affectations = EnseignantMatiereClasse::with([
                'enseignant.user', 
                'matiere', 
                'classe', 
                'anneeScolaire'
            ])
            ->when($search, function ($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->whereHas('enseignant', function ($query) use ($search) {
                        $query->where('nom', 'like', "%{$search}%")
                              ->orWhere('prenom', 'like', "%{$search}%")
                              ->orWhere('matricule', 'like', "%{$search}%");
                    })
                    ->orWhereHas('matiere', function ($query) use ($search) {
                        $query->where('nom', 'like', "%{$search}%")
                              ->orWhere('code', 'like', "%{$search}%");
                    })
                    ->orWhereHas('classe', function ($query) use ($search) {
                        $query->where('nom', 'like', "%{$search}%");
                    });
                });
            })
            ->when($enseignant_id, function ($query) use ($enseignant_id) {
                return $query->where('enseignant_id', $enseignant_id);
            })
            ->when($classe_id, function ($query) use ($classe_id) {
                return $query->where('classe_id', $classe_id);
            })
            ->when($matiere_id, function ($query) use ($matiere_id) {
                return $query->where('matiere_id', $matiere_id);
            })
            ->when($annee_scolaire_id, function ($query) use ($annee_scolaire_id) {
                return $query->where('annee_scolaire_id', $annee_scolaire_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // ✅ STATISTIQUES COMPLÈTES (avec les clés manquantes ajoutées)
        $stats = [
            'total' => EnseignantMatiereClasse::count(),
            'total_enseignants' => EnseignantMatiereClasse::distinct('enseignant_id')->count('enseignant_id'),
            'total_classes' => EnseignantMatiereClasse::distinct('classe_id')->count('classe_id'),
            'total_matieres' => EnseignantMatiereClasse::distinct('matiere_id')->count('matiere_id'),
            'total_annees' => EnseignantMatiereClasse::distinct('annee_scolaire_id')->count('annee_scolaire_id'),
            'par_enseignant' => EnseignantMatiereClasse::select('enseignant_id', DB::raw('count(*) as total'))
                ->groupBy('enseignant_id')
                ->orderBy('total', 'desc')
                ->with('enseignant')
                ->limit(5)
                ->get(),
            'par_annee' => EnseignantMatiereClasse::select('annee_scolaire_id', DB::raw('count(*) as total'))
                ->groupBy('annee_scolaire_id')
                ->with('anneeScolaire')
                ->get(),
            'affectations_sans_doublon' => EnseignantMatiereClasse::select('enseignant_id', 'matiere_id', 'classe_id', 'annee_scolaire_id')
                ->distinct()
                ->count(),
        ];

        // Données pour les filtres
        $enseignants = Enseignant::with('user')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();
            
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        
        // ✅ CORRECTION : Remplacer 'annee' par la colonne appropriée
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();

        return view('admin.enseignant_matiere_classes.index', compact(
            'affectations', 
            'search', 
            'enseignant_id',
            'classe_id', 
            'matiere_id', 
            'annee_scolaire_id',
            'classes', 
            'matieres', 
            'anneeScolaires', 
            'enseignants',
            'stats'
        ));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $enseignants = Enseignant::with('user')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();
            
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();

        return view('admin.enseignant_matiere_classes.create', compact(
            'enseignants', 'classes', 'matieres', 'anneeScolaires'
        ));
    }

    /**
     * Enregistre une nouvelle affectation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'enseignant_id' => 'required|exists:enseignants,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
        ]);

        // Vérifier si l'affectation existe déjà
        $existing = EnseignantMatiereClasse::where('enseignant_id', $validated['enseignant_id'])
            ->where('matiere_id', $validated['matiere_id'])
            ->where('classe_id', $validated['classe_id'])
            ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cette affectation existe déjà pour cette année scolaire.');
        }

        try {
            EnseignantMatiereClasse::create($validated);

            return redirect()->route('admin.enseignant-matiere-classes.index')
                ->with('success', 'Affectation créée avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création : ' . $e->getMessage());
        }
    }

    /**
     * Affiche une affectation spécifique
     */
    public function show(EnseignantMatiereClasse $enseignantMatiereClasse)
    {
        $enseignantMatiereClasse->load([
            'enseignant.user', 
            'matiere', 
            'classe', 
            'anneeScolaire'
        ]);
        
        // Vérifier si l'enseignant a d'autres affectations
        $autresAffectations = EnseignantMatiereClasse::where('enseignant_id', $enseignantMatiereClasse->enseignant_id)
            ->where('id', '!=', $enseignantMatiereClasse->id)
            ->with(['matiere', 'classe', 'anneeScolaire'])
            ->limit(5)
            ->get();

        return view('admin.enseignant_matiere_classes.show', compact(
            'enseignantMatiereClasse', 
            'autresAffectations'
        ));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(EnseignantMatiereClasse $enseignantMatiereClasse)
    {
        $enseignants = Enseignant::with('user')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();
            
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();

        return view('admin.enseignant_matiere_classes.edit', compact(
            'enseignantMatiereClasse', 
            'enseignants', 
            'classes', 
            'matieres', 
            'anneeScolaires'
        ));
    }

    /**
     * Met à jour une affectation
     */
    public function update(Request $request, EnseignantMatiereClasse $enseignantMatiereClasse)
    {
        $validated = $request->validate([
            'enseignant_id' => 'required|exists:enseignants,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
        ]);

        // Vérifier si l'affectation existe déjà (en excluant l'enregistrement actuel)
        $existing = EnseignantMatiereClasse::where('enseignant_id', $validated['enseignant_id'])
            ->where('matiere_id', $validated['matiere_id'])
            ->where('classe_id', $validated['classe_id'])
            ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
            ->where('id', '!=', $enseignantMatiereClasse->id)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cette affectation existe déjà pour cette année scolaire.');
        }

        try {
            $enseignantMatiereClasse->update($validated);

            return redirect()->route('admin.enseignant-matiere-classes.show', $enseignantMatiereClasse)
                ->with('success', 'Affectation mise à jour avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }

    /**
     * Supprime une affectation
     */
    public function destroy(EnseignantMatiereClasse $enseignantMatiereClasse)
    {
        try {
            // Vérifier s'il y a des dépendances (évaluations, emplois du temps, etc.)
            // À adapter selon votre logique métier
            
            $enseignantMatiereClasse->delete();

            return redirect()->route('admin.enseignant-matiere-classes.index')
                ->with('success', 'Affectation supprimée avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    /**
     * API : Récupérer les affectations pour un select
     */
    public function getForSelect(Request $request)
    {
        $search = $request->get('search', '');
        
        $affectations = EnseignantMatiereClasse::with(['enseignant', 'matiere', 'classe', 'anneeScolaire'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('enseignant', function ($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%")
                      ->orWhere('prenom', 'like', "%{$search}%");
                });
            })
            ->limit(20)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->enseignant->nom . ' ' . $item->enseignant->prenom . 
                             ' - ' . $item->matiere->nom . 
                             ' - ' . $item->classe->nom .
                             ' (' . $item->anneeScolaire->nom . ')',
                ];
            });

        return response()->json($affectations);
    }

    /**
     * API : Vérifier si une affectation existe déjà
     */
    public function checkExisting(Request $request)
    {
        $request->validate([
            'enseignant_id' => 'required|exists:enseignants,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'ignore_id' => 'nullable|exists:enseignant_matiere_classe,id',
        ]);

        $query = EnseignantMatiereClasse::where('enseignant_id', $request->enseignant_id)
            ->where('matiere_id', $request->matiere_id)
            ->where('classe_id', $request->classe_id)
            ->where('annee_scolaire_id', $request->annee_scolaire_id);

        if ($request->filled('ignore_id')) {
            $query->where('id', '!=', $request->ignore_id);
        }

        $exists = $query->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Cette affectation existe déjà' : 'Affectation disponible'
        ]);
    }

    /**
     * API : Obtenir les statistiques rapides
     */
    public function getQuickStats()
    {
        $stats = [
            'total' => EnseignantMatiereClasse::count(),
            'total_enseignants' => EnseignantMatiereClasse::distinct('enseignant_id')->count('enseignant_id'),
            'total_classes' => EnseignantMatiereClasse::distinct('classe_id')->count('classe_id'),
            'total_matieres' => EnseignantMatiereClasse::distinct('matiere_id')->count('matiere_id'),
            'total_annees' => EnseignantMatiereClasse::distinct('annee_scolaire_id')->count('annee_scolaire_id'),
        ];

        return response()->json($stats);
    }
}