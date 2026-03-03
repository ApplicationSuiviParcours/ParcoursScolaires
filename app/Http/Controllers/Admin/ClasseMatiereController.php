<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClasseMatiere;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Enseignant;
use Illuminate\Support\Facades\DB;

class ClasseMatiereController extends Controller
{
    /**
     * Affiche la liste des matières par classe
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $classeId = $request->get('classe_id');
        
        $classes = Classe::with(['matieres' => function($query) {
                $query->with(['matiere']);
            }])
            ->when($search, function ($query) use ($search) {
                return $query->where('nom', 'like', "%{$search}%");
            })
            ->when($classeId, function ($query) use ($classeId) {
                return $query->where('id', $classeId);
            })
            ->orderBy('nom')
            ->get();

        // Statistiques
        $stats = [
            'total_classes' => Classe::count(),
            'total_assignations' => ClasseMatiere::count(),
            'moyenne_coefficient' => round(ClasseMatiere::avg('coefficient') ?? 0, 2),
            'classes_avec_matieres' => Classe::has('matieres')->count(),
        ];

        return view('admin.classe_matieres.index', compact('classes', 'stats', 'search', 'classeId'));
    }

    /**
     * Affiche le formulaire pour gérer les matières d'une classe
     */
    public function manage(Request $request)
    {
        $classeId = $request->get('classe_id');
        
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        
        $classeMatieres = [];
        $classe = null;
        
        if ($classeId) {
            $classe = Classe::find($classeId);
            $classeMatieres = ClasseMatiere::where('classe_id', $classeId)
                ->with(['matiere'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Statistiques pour la classe sélectionnée
        $stats = [];
        if ($classe) {
            $stats = [
                'total_matieres' => $classeMatieres->count(),
                'coefficient_total' => $classeMatieres->sum('coefficient'),
                'coefficient_moyen' => $classeMatieres->isNotEmpty() ? round($classeMatieres->avg('coefficient'), 2) : 0,
            ];
        }

        return view('admin.classe_matieres.manage', compact(
            'classes', 
            'matieres', 
            'classeMatieres', 
            'classeId',
            'classe',
            'stats'
        ));
    }

    /**
     * Ajoute une matière à une classe
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'coefficient' => 'required|numeric|min:0.5|max:10',
        ]);

        try {
            DB::beginTransaction();

            // Vérifier si l'association existe déjà
            $exists = ClasseMatiere::where('classe_id', $validated['classe_id'])
                ->where('matiere_id', $validated['matiere_id'])
                ->exists();

            if ($exists) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Cette matière est déjà assignée à cette classe.');
            }

            ClasseMatiere::create($validated);

            DB::commit();

            return redirect()->route('admin.classe-matieres.manage', ['classe_id' => $validated['classe_id']])
                ->with('success', 'Matière assignée à la classe avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'assignation : ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d'une assignation
     */
    public function show(ClasseMatiere $classeMatiere)
    {
        $classeMatiere->load(['classe', 'matiere']);
        
        return view('admin.classe_matieres.show', compact('classeMatiere'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(ClasseMatiere $classeMatiere)
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        
        return view('admin.classe_matieres.edit', compact('classeMatiere', 'classes', 'matieres'));
    }

    /**
     * Met à jour une matière d'une classe
     */
    public function update(Request $request, ClasseMatiere $classeMatiere)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'coefficient' => 'required|numeric|min:0.5|max:10',
        ]);

        try {
            DB::beginTransaction();

            // Vérifier si l'association existe déjà (sauf pour l'enregistrement actuel)
            $exists = ClasseMatiere::where('classe_id', $validated['classe_id'])
                ->where('matiere_id', $validated['matiere_id'])
                ->where('id', '!=', $classeMatiere->id)
                ->exists();

            if ($exists) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Cette matière est déjà assignée à cette classe.');
            }

            $classeMatiere->update($validated);

            DB::commit();

            return redirect()->route('admin.classe-matieres.manage', ['classe_id' => $validated['classe_id']])
                ->with('success', 'Matière mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * Supprime une matière d'une classe
     */
    public function destroy(ClasseMatiere $classeMatiere)
    {
        try {
            DB::beginTransaction();

            $classeId = $classeMatiere->classe_id;
            
            // Vérifier s'il y a des dépendances (évaluations, emplois du temps, etc.)
            // À adapter selon votre logique métier
            if ($classeMatiere->evaluations()->exists()) {
                return redirect()->back()
                    ->with('error', 'Impossible de supprimer cette assignation car elle est utilisée dans des évaluations.');
            }

            $classeMatiere->delete();

            DB::commit();

            return redirect()->route('admin.classe-matieres.manage', ['classe_id' => $classeId])
                ->with('success', 'Matière retirée de la classe avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la suppression : ' . $e->getMessage());
        }
    }

    /**
     * API : Récupérer les matières d'une classe
     */
    public function getMatieresByClasse(Classe $classe)
    {
        $matieres = $classe->matieres()
            ->with('matiere')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'matiere_id' => $item->matiere_id,
                    'matiere_nom' => $item->matiere->nom,
                    'matiere_code' => $item->matiere->code,
                    'coefficient' => $item->coefficient,
                ];
            });

        return response()->json($matieres);
    }

    /**
     * API : Vérifier si une matière est déjà assignée
     */
    public function checkExisting(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'ignore_id' => 'nullable|exists:classe_matieres,id',
        ]);

        $query = ClasseMatiere::where('classe_id', $request->classe_id)
            ->where('matiere_id', $request->matiere_id);

        if ($request->filled('ignore_id')) {
            $query->where('id', '!=', $request->ignore_id);
        }

        $exists = $query->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Cette matière est déjà assignée' : 'Matière disponible'
        ]);
    }

    /**
     * API : Obtenir les statistiques rapides
     */
    public function getQuickStats()
    {
        $stats = [
            'total_assignations' => ClasseMatiere::count(),
            'total_classes' => Classe::count(),
            'total_matieres' => Matiere::count(),
            'moyenne_coefficient' => round(ClasseMatiere::avg('coefficient') ?? 0, 2),
            'classes_avec_matieres' => Classe::has('matieres')->count(),
            'coefficient_max' => ClasseMatiere::max('coefficient') ?? 0,
            'coefficient_min' => ClasseMatiere::min('coefficient') ?? 0,
        ];

        return response()->json($stats);
    }

    /**
     * API : Obtenir les matières disponibles pour une classe
     */
    public function getMatieresDisponibles(Classe $classe)
    {
        $matieresAssignees = $classe->matieres()->pluck('matiere_id')->toArray();
        
        $matieresDisponibles = Matiere::whereNotIn('id', $matieresAssignees)
            ->orderBy('nom')
            ->get()
            ->map(function ($matiere) {
                return [
                    'id' => $matiere->id,
                    'nom' => $matiere->nom,
                    'code' => $matiere->code,
                ];
            });

        return response()->json($matieresDisponibles);
    }
}