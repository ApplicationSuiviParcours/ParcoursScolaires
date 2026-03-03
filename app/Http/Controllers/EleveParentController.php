<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe; // Ajouté
use App\Models\ParentEleve;
use App\Models\EleveParent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EleveParentsExport;

class EleveParentController extends Controller
{
    /**
     * Afficher la liste des relations élèves-parents.
     */
    public function index(Request $request)
    {
        $query = EleveParent::with(['eleve', 'parentEleve']); // Retiré 'eleve.classe'
        
        // Filtres optionnels
        if ($request->has('classe_id') && $request->classe_id) {
            $query->whereHas('eleve', function($q) use ($request) {
                $q->whereHas('inscriptions', function($inscriptionQuery) use ($request) {
                    $inscriptionQuery->where('classe_id', $request->classe_id)
                                    ->where('statut', true);
                });
            });
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('eleve', function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%");
            })->orWhereHas('parentEleve', function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%");
            });
        }
        
        $relations = $query->paginate(15);
        
        // Récupérer les classes pour le filtre
        $classes = Classe::all();
        
        return view('admin.eleve_parents.index', compact('relations', 'classes'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        // Remplacer Eleve::with('classe') par Eleve::with('inscriptions.classe')
        $eleves = Eleve::with(['inscriptions' => function($query) {
            $query->where('statut', true)->with('classe');
        }])->get();
        
        $parents = ParentEleve::all();
        $eleveParent = new EleveParent();
        
        return view('admin.eleve_parents.create', compact('eleves', 'parents', 'eleveParent'));
    }

    /**
     * Enregistrer une nouvelle relation élève-parent.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'parent_eleve_id' => 'required|exists:parent_eleves,id',
            'lien_parental' => 'required|string|max:50',
        ]);

        // Vérifier si la relation existe déjà
        $existingRelation = EleveParent::where('eleve_id', $validated['eleve_id'])
            ->where('parent_eleve_id', $validated['parent_eleve_id'])
            ->first();

        if ($existingRelation) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cette relation élève-parent existe déjà.');
        }

        $relation = EleveParent::create($validated);

        return redirect()->route('admin.eleve-parents.index')
            ->with('success', 'Relation élève-parent créée avec succès.');
    }

    /**
     * Afficher une relation spécifique.
     */
    public function show(EleveParent $eleveParent)
    {
        // Remplacer 'eleve.classe' par le chargement approprié
        $eleveParent->load(['eleve.inscriptions.classe', 'parentEleve']);
        return view('admin.eleve_parents.show', compact('eleveParent'));
    }

    /**
     * Afficher le formulaire d'édition.
     */
    public function edit(EleveParent $eleveParent)
    {
        // Remplacer Eleve::with('classe') par Eleve::with('inscriptions.classe')
        $eleves = Eleve::with(['inscriptions' => function($query) {
            $query->where('statut', true)->with('classe');
        }])->get();
        
        $parents = ParentEleve::all();
        
        return view('admin.eleve_parents.edit', compact('eleveParent', 'eleves', 'parents'));
    }

    /**
     * Mettre à jour une relation spécifique.
     */
    public function update(Request $request, EleveParent $eleveParent)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'parent_eleve_id' => 'required|exists:parent_eleves,id',
            'lien_parental' => 'required|string|max:50',
        ]);

        // Vérifier les doublons
        $existingRelation = EleveParent::where('eleve_id', $validated['eleve_id'])
            ->where('parent_eleve_id', $validated['parent_eleve_id'])
            ->where('id', '!=', $eleveParent->id)
            ->first();

        if ($existingRelation) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cette relation élève-parent existe déjà.');
        }

        $eleveParent->update($validated);

        return redirect()->route('admin.eleve-parents.index')
            ->with('success', 'Relation élève-parent mise à jour avec succès.');
    }

    /**
     * Supprimer une relation spécifique.
     */
    public function destroy(EleveParent $eleveParent)
    {
        $eleveParent->delete();

        return redirect()->route('admin.eleve-parents.index')
            ->with('success', 'Relation élève-parent supprimée avec succès.');
    }

    /**
     * Récupérer tous les parents d'un élève spécifique (API).
     */
    public function getParentsByEleve(Eleve $eleve)
    {
        $parents = $eleve->parents()->withPivot('lien_parental')->get();
        
        return response()->json([
            'eleve' => [
                'id' => $eleve->id,
                'nom_complet' => $eleve->nom_complet,
                'matricule' => $eleve->matricule,
                'classe_actuelle' => $eleve->classe_actuelle,
            ],
            'parents' => $parents->map(function($parent) {
                return [
                    'id' => $parent->id,
                    'nom_complet' => $parent->nom_complet,
                    'lien_parental' => $parent->pivot->lien_parental,
                ];
            })
        ]);
    }

    /**
     * Récupérer tous les élèves d'un parent spécifique (API).
     */
    public function getElevesByParent(ParentEleve $parent)
    {
        $eleves = $parent->eleves()->withPivot('lien_parental')->get();
        
        return response()->json([
            'parent' => [
                'id' => $parent->id,
                'nom_complet' => $parent->nom_complet,
            ],
            'eleves' => $eleves->map(function($eleve) {
                return [
                    'id' => $eleve->id,
                    'nom_complet' => $eleve->nom_complet,
                    'matricule' => $eleve->matricule,
                    'classe_actuelle' => $eleve->classe_actuelle,
                    'lien_parental' => $eleve->pivot->lien_parental,
                ];
            })
        ]);
    }

    /**
     * Supprimer toutes les relations pour un élève spécifique.
     */
    public function deleteByEleve(Eleve $eleve)
    {
        $count = EleveParent::where('eleve_id', $eleve->id)->delete();
        
        return redirect()->route('admin.eleve-parents.index')
            ->with('success', "{$count} relation(s) supprimée(s) pour l'élève {$eleve->nom_complet}.");
    }

    /**
     * Supprimer toutes les relations pour un parent spécifique.
     */
    public function deleteByParent(ParentEleve $parent)
    {
        $count = EleveParent::where('parent_eleve_id', $parent->id)->delete();
        
        return redirect()->route('admin.eleve-parents.index')
            ->with('success', "{$count} relation(s) supprimée(s) pour le parent {$parent->nom_complet}.");
    }

    // ============ NOUVELLES MÉTHODES D'EXPORT ============

    /**
     * Exporter toutes les relations au format PDF.
     */
    public function exportPdf()
    {
        $relations = EleveParent::with(['eleve.inscriptions.classe', 'parentEleve'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($relation) {
                $relation->classe_eleve = $relation->eleve->classe_actuelle;
                return $relation;
            });
        
        $stats = $this->getExportStats();
        
        $pdf = Pdf::loadView('admin.eleve_parents.exports.pdf', compact('relations', 'stats'));
        
        return $pdf->download('relations-eleves-parents-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exporter toutes les relations au format Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new EleveParentsExport, 'relations-eleves-parents-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Générer un PDF pour une relation spécifique.
     */
    public function generatePdf(EleveParent $eleveParent)
    {
        $eleveParent->load(['eleve.inscriptions.classe', 'parentEleve']);
        $eleveParent->classe_eleve = $eleveParent->eleve->classe_actuelle;
        
        $pdf = Pdf::loadView('admin.eleve_parents.exports.single-pdf', compact('eleveParent'));
        
        return $pdf->download('relation-' . $eleveParent->id . '-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exporter les relations filtrées par élève.
     */
    public function exportByElevePdf(Eleve $eleve)
    {
        $relations = EleveParent::with(['parentEleve'])
            ->where('eleve_id', $eleve->id)
            ->get()
            ->map(function($relation) use ($eleve) {
                $relation->classe_eleve = $eleve->classe_actuelle;
                return $relation;
            });
        
        $pdf = Pdf::loadView('admin.eleve_parents.exports.by-eleve-pdf', compact('relations', 'eleve'));
        
        return $pdf->download('relations-' . $eleve->nom . '-' . $eleve->prenom . '-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exporter les relations filtrées par parent.
     */
    public function exportByParentPdf(ParentEleve $parent)
    {
        $relations = EleveParent::with(['eleve.inscriptions.classe'])
            ->where('parent_eleve_id', $parent->id)
            ->get()
            ->map(function($relation) {
                $relation->classe_eleve = $relation->eleve->classe_actuelle;
                return $relation;
            });
        
        $pdf = Pdf::loadView('admin.eleve_parents.exports.by-parent-pdf', compact('relations', 'parent'));
        
        return $pdf->download('relations-' . $parent->nom . '-' . $parent->prenom . '-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Prévisualiser le PDF avant téléchargement.
     */
    public function previewPdf()
    {
        $relations = EleveParent::with(['eleve.inscriptions.classe', 'parentEleve'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($relation) {
                $relation->classe_eleve = $relation->eleve->classe_actuelle;
                return $relation;
            });
        
        $stats = $this->getExportStats();
        
        $pdf = Pdf::loadView('admin.eleve_parents.exports.pdf', compact('relations', 'stats'));
        
        return $pdf->stream('apercu-relations-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Obtenir les statistiques pour les exports.
     */
    private function getExportStats()
    {
        return [
            'total_relations' => EleveParent::count(),
            'total_eleves' => Eleve::count(),
            'total_parents' => ParentEleve::count(),
            'eleves_avec_parents' => Eleve::has('parents')->count(),
            'parents_avec_eleves' => ParentEleve::has('eleves')->count(),
            'repartition_lien' => EleveParent::select('lien_parental')
                ->selectRaw('count(*) as total')
                ->groupBy('lien_parental')
                ->get()
                ->pluck('total', 'lien_parental')
                ->toArray()
        ];
    }

    /**
     * AJOUT: Récupérer toutes les classes pour le filtre (API)
     */
    public function getClasses()
    {
        return response()->json(Classe::all());
    }
}