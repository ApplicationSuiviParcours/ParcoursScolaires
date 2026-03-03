<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use Illuminate\Support\Facades\Auth;

class EvaluationAdminController extends Controller
{
    /**
     * Affiche la liste des évaluations
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $classe_id = $request->get('classe_id');
        $matiere_id = $request->get('matiere_id');
        $periode = $request->get('periode');
        
        $evaluations = Evaluation::with(['classe', 'matiere', 'anneeScolaire', 'enseignant'])
            ->when($search, function ($query) use ($search) {
                return $query->where('nom', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($classe_id, function ($query) use ($classe_id) {
                return $query->where('classe_id', $classe_id);
            })
            ->when($matiere_id, function ($query) use ($matiere_id) {
                return $query->where('matiere_id', $matiere_id);
            })
            ->when($periode, function ($query) use ($periode) {
                return $query->where('periode', $periode);
            })
            ->orderBy('date_evaluation', 'desc')
            ->paginate(15);

        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        
        return view('admin.evaluations.index', compact(
            'evaluations', 'search', 'classe_id', 'matiere_id', 'periode',
            'classes', 'matieres'
        ));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        
        // CORRECTION: Utiliser 'nom' au lieu de 'annee'
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();

        return view('admin.evaluations.create', compact('classes', 'matieres', 'anneeScolaires'));
    }

    /**
     * Enregistre une nouvelle évaluation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'type' => 'required|in:devoir,examen,test,projet,autre',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_evaluation' => 'required|date',
            'coefficient' => 'required|numeric|min:1|max:10',
            'bareme' => 'required|numeric|min:0|max:100',
            'periode' => 'nullable|string|max:50',
        ]);

        // Ajout de l'ID de l'enseignant connecté
        $validated['enseignant_id'] = Auth::id();

        Evaluation::create($validated);

        return redirect()->route('admin.evaluations.index')
            ->with('success', 'Évaluation créée avec succès.');
    }

    /**
     * Affiche une évaluation spécifique
     */
    public function show(Evaluation $evaluation)
    {
        $evaluation->load(['classe', 'matiere', 'anneeScolaire', 'enseignant', 'notes.eleve']);
        
        // Calcul des statistiques
        $statistiques = [
            'moyenne' => $evaluation->moyenne(),
            'taux_reussite' => $evaluation->tauxReussite(),
            'notes_count' => $evaluation->notes()->count(),
            'notes_min' => $evaluation->notes()->min('note'),
            'notes_max' => $evaluation->notes()->max('note'),
        ];
        
        return view('admin.evaluations.show', compact('evaluation', 'statistiques'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Evaluation $evaluation)
    {
        // Vérification que l'enseignant connecté est bien le propriétaire
        if ($evaluation->enseignant_id !== Auth::id()) {
            return redirect()->route('admin.evaluations.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette évaluation.');
        }

        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        
        // CORRECTION: Utiliser 'nom' au lieu de 'annee'
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        
        return view('admin.evaluations.edit', compact('evaluation', 'classes', 'matieres', 'anneeScolaires'));
    }

    /**
     * Met à jour une évaluation
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        // Vérification que l'enseignant connecté est bien le propriétaire
        if ($evaluation->enseignant_id !== Auth::id()) {
            return redirect()->route('admin.evaluations.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette évaluation.');
        }

        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'type' => 'required|in:devoir,examen,test,projet,autre',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_evaluation' => 'required|date',
            'coefficient' => 'required|numeric|min:1|max:10',
            'bareme' => 'required|numeric|min:0|max:100',
            'periode' => 'nullable|string|max:50',
        ]);

        $evaluation->update($validated);

        return redirect()->route('admin.evaluations.show', $evaluation)
            ->with('success', 'Évaluation mise à jour avec succès.');
    }

    /**
     * Supprime une évaluation
     */
    public function destroy(Evaluation $evaluation)
    {
        // Vérification que l'enseignant connecté est bien le propriétaire
        if ($evaluation->enseignant_id !== Auth::id()) {
            return redirect()->route('admin.evaluations.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette évaluation.');
        }

        // Vérification si l'évaluation a des notes avant suppression
        if ($evaluation->hasNotes()) {
            return redirect()->route('admin.evaluations.show', $evaluation)
                ->with('error', 'Impossible de supprimer cette évaluation car elle a déjà des notes saisies.');
        }

        $evaluation->delete();

        return redirect()->route('admin.evaluations.index')
            ->with('success', 'Évaluation supprimée avec succès.');
    }

    /**
     * Affiche les évaluations à venir
     */
    public function upcoming()
    {
        $evaluations = Evaluation::with(['classe', 'matiere'])
            ->upcoming()
            ->orderBy('date_evaluation')
            ->paginate(15);

        return view('admin.evaluations.upcoming', compact('evaluations'));
    }

    /**
     * Affiche les évaluations passées
     */
    public function past()
    {
        $evaluations = Evaluation::with(['classe', 'matiere'])
            ->past()
            ->orderBy('date_evaluation', 'desc')
            ->paginate(15);

        return view('admin.evaluations.past', compact('evaluations'));
    }

    /**
     * Duplique une évaluation
     */
    public function duplicate(Evaluation $evaluation)
    {
        // Vérification que l'enseignant connecté est bien le propriétaire
        if ($evaluation->enseignant_id !== Auth::id()) {
            return redirect()->route('admin.evaluations.index')
                ->with('error', 'Vous n\'êtes pas autorisé à dupliquer cette évaluation.');
        }

        $newEvaluation = $evaluation->replicate();
        $newEvaluation->nom = $newEvaluation->nom . ' (copie)';
        $newEvaluation->date_evaluation = now()->addDays(7);
        $newEvaluation->save();

        return redirect()->route('admin.evaluations.show', $newEvaluation)
            ->with('success', 'Évaluation dupliquée avec succès.');
    }

    /**
     * Exporte les notes d'une évaluation
     */
    public function export(Evaluation $evaluation)
    {
        // Vérification que l'enseignant connecté est bien le propriétaire
        if ($evaluation->enseignant_id !== Auth::id()) {
            return redirect()->route('admin.evaluations.index')
                ->with('error', 'Vous n\'êtes pas autorisé à exporter cette évaluation.');
        }

        $evaluation->load(['notes.eleve', 'classe', 'matiere']);
        
        return redirect()->back()->with('info', 'Fonctionnalité d\'export en cours de développement.');
    }
}