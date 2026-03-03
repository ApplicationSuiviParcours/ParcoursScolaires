<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enseignant;
use App\Models\Evaluation;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use App\Models\EnseignantMatiereClasse;
use App\Models\Note;

class EvaluationController extends Controller
{
    protected $enseignant;

    /**
     * Constructor avec middleware pour vérifier l'enseignant
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->enseignant = Enseignant::where('user_id', Auth::id())->first();
            
            if (!$this->enseignant) {
                return redirect()->route('dashboard')
                    ->with('error', 'Aucun enseignant associé à ce compte.');
            }
            
            return $next($request);
        });
    }

    /**
     * Affiche la liste des évaluations
     */
    public function index()
    {
        $evaluations = Evaluation::where('enseignant_id', $this->enseignant->id)
            ->with(['classe', 'matiere', 'notes'])
            ->orderBy('date_evaluation', 'desc')
            ->get();

        // Récupérer les classes via EnseignantMatiereClasse
        $classeIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->distinct('classe_id')
            ->pluck('classe_id');
            
        $classes = Classe::whereIn('id', $classeIds)->get();

        // Récupérer les matières via EnseignantMatiereClasse
        $matiereIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->distinct('matiere_id')
            ->pluck('matiere_id');
            
        $matieres = Matiere::whereIn('id', $matiereIds)->get();

        $anneesScolaires = AnneeScolaire::all();
        $anneeScolaireActive = AnneeScolaire::where('active', true)->first();

        return view('enseignant.evaluations', compact(
            'evaluations',
            'classes',
            'matieres',
            'anneesScolaires',
            'anneeScolaireActive'
        ));
    }

    /**
     * Affiche le formulaire de création d'évaluation
     */
    public function create()
    {
        // Récupérer les classes de l'enseignant
        $classeIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->distinct('classe_id')
            ->pluck('classe_id');
            
        $classes = Classe::whereIn('id', $classeIds)->get();

        // Récupérer les matières de l'enseignant
        $matiereIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->distinct('matiere_id')
            ->pluck('matiere_id');
            
        $matieres = Matiere::whereIn('id', $matiereIds)->get();

        $anneesScolaires = AnneeScolaire::all();
        $anneeScolaireActive = AnneeScolaire::where('active', true)->first();

        // IMPORTANT: Initialiser $evaluations comme une collection vide pour éviter l'erreur
        $evaluations = collect([]);

        return view('enseignant.evaluations', compact(
            'evaluations', // Ajout de cette variable
            'classes',
            'matieres',
            'anneesScolaires',
            'anneeScolaireActive'
        ));
    }

    /**
     * Enregistre une nouvelle évaluation
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'type' => 'required|in:devoir,examen,interrogation,projet',
            'periode' => 'required|string',
            'date_evaluation' => 'required|date',
            'coefficient' => 'required|numeric|min:0.5|max:10',
            'bareme' => 'required|numeric|min:0|max:40',
            'description' => 'nullable|string',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
        ]);

        // Vérifier que l'enseignant a bien accès à cette classe et matière
        $acces = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->where('classe_id', $request->classe_id)
            ->where('matiere_id', $request->matiere_id)
            ->exists();

        if (!$acces) {
            return back()->withErrors(['error' => "Vous n'êtes pas autorisé à créer une évaluation pour cette classe et matière."])->withInput();
        }

        Evaluation::create([
            'enseignant_id' => $this->enseignant->id,
            'classe_id' => $request->classe_id,
            'matiere_id' => $request->matiere_id,
            'annee_scolaire_id' => $request->annee_scolaire_id,
            'type' => $request->type,
            'nom' => $request->nom,
            'description' => $request->description,
            'date_evaluation' => $request->date_evaluation,
            'coefficient' => $request->coefficient,
            'bareme' => $request->bareme,
            'periode' => $request->periode,
        ]);

        return redirect()->route('enseignant.evaluations.index')
            ->with('success', 'Évaluation créée avec succès.');
    }

    /**
     * Affiche les détails d'une évaluation
     */
    public function show($id)
    {
        $evaluation = Evaluation::where('enseignant_id', $this->enseignant->id)
            ->with(['classe', 'matiere', 'notes.eleve'])
            ->findOrFail($id);

        // Statistiques pour l'évaluation
        $stats = [
            'total_eleves' => $evaluation->classe->eleves()->count(),
            'notes_saisies' => $evaluation->notes->count(),
            'moyenne' => $evaluation->notes->avg('note'),
            'note_min' => $evaluation->notes->min('note'),
            'note_max' => $evaluation->notes->max('note'),
            'taux_reussite' => $evaluation->notes->where('note', '>=', 10)->count() / max($evaluation->notes->count(), 1) * 100,
        ];

        return view('enseignant.evaluations-show', compact('evaluation', 'stats'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id)
    {
        $evaluation = Evaluation::where('enseignant_id', $this->enseignant->id)->findOrFail($id);
        
        $classeIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->distinct('classe_id')
            ->pluck('classe_id');
            
        $classes = Classe::whereIn('id', $classeIds)->get();

        $matiereIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->distinct('matiere_id')
            ->pluck('matiere_id');
            
        $matieres = Matiere::whereIn('id', $matiereIds)->get();

        $anneesScolaires = AnneeScolaire::all();

        return view('enseignant.evaluations-edit', compact('evaluation', 'classes', 'matieres', 'anneesScolaires'));
    }

    /**
     * Met à jour une évaluation
     */
    public function update(Request $request, $id)
    {
        $evaluation = Evaluation::where('enseignant_id', $this->enseignant->id)->findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'type' => 'required|in:devoir,examen,interrogation,projet',
            'periode' => 'required|string',
            'date_evaluation' => 'required|date',
            'coefficient' => 'required|numeric|min:0.5|max:10',
            'bareme' => 'required|numeric|min:0|max:40',
            'description' => 'nullable|string',
        ]);

        $evaluation->update($request->all());

        return redirect()->route('enseignant.evaluations.index')
            ->with('success', 'Évaluation mise à jour avec succès.');
    }

    /**
     * Supprime une évaluation
     */
    public function destroy($id)
    {
        $evaluation = Evaluation::where('enseignant_id', $this->enseignant->id)->findOrFail($id);
        
        // Vérifier s'il y a des notes associées
        if ($evaluation->notes()->count() > 0) {
            return redirect()->route('enseignant.evaluations.index')
                ->with('error', 'Impossible de supprimer cette évaluation car des notes y sont associées.');
        }

        $evaluation->delete();

        return redirect()->route('enseignant.evaluations.index')
            ->with('success', 'Évaluation supprimée avec succès.');
    }

    /**
     * Duplique une évaluation
     */
    public function duplicate($id)
    {
        $evaluation = Evaluation::where('enseignant_id', $this->enseignant->id)->findOrFail($id);
        
        $nouvelleEvaluation = $evaluation->replicate();
        $nouvelleEvaluation->nom = $nouvelleEvaluation->nom . ' (copie)';
        $nouvelleEvaluation->date_evaluation = now()->addDays(7);
        $nouvelleEvaluation->save();

        return redirect()->route('enseignant.evaluations.index')
            ->with('success', 'Évaluation dupliquée avec succès.');
    }

    /**
     * Statistiques d'une évaluation
     */
    public function statistiques($id)
    {
        $evaluation = Evaluation::where('enseignant_id', $this->enseignant->id)
            ->with(['notes', 'classe', 'matiere'])
            ->findOrFail($id);

        // Récupérer tous les élèves de la classe
        $eleves = $evaluation->classe->eleves()->get();
        
        // Statistiques détaillées
        $stats = [
            'total_eleves' => $eleves->count(),
            'notes_saisies' => $evaluation->notes->count(),
            'taux_saisie' => $eleves->count() > 0 ? round(($evaluation->notes->count() / $eleves->count()) * 100, 2) : 0,
            'moyenne' => round($evaluation->notes->avg('note') ?? 0, 2),
            'note_min' => $evaluation->notes->min('note') ?? 0,
            'note_max' => $evaluation->notes->max('note') ?? 0,
            'taux_reussite' => $evaluation->notes->where('note', '>=', 10)->count() / max($evaluation->notes->count(), 1) * 100,
            'distribution' => [
                'tres_bien' => $evaluation->notes->where('note', '>=', 16)->count(),
                'bien' => $evaluation->notes->whereBetween('note', [14, 15.99])->count(),
                'assez_bien' => $evaluation->notes->whereBetween('note', [12, 13.99])->count(),
                'passable' => $evaluation->notes->whereBetween('note', [10, 11.99])->count(),
                'insuffisant' => $evaluation->notes->where('note', '<', 10)->count(),
            ],
        ];

        return view('enseignant.evaluations-statistiques', compact('evaluation', 'stats'));
    }

    /**
     * Récupère les élèves d'une classe pour une évaluation
     */
    public function getElevesByClasse($classeId)
    {
        $classe = Classe::findOrFail($classeId);
        $eleves = $classe->eleves()->get();

        return response()->json($eleves);
    }
}