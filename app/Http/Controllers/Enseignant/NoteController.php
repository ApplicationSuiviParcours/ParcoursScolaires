<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Enseignant;
use App\Models\Note;
use App\Models\Eleve;
use App\Models\Evaluation;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Inscription;
use App\Models\EnseignantMatiereClasse;
use Carbon\Carbon;

class NoteController extends Controller
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
     * Affiche la liste des notes
     * Route: GET /enseignant/notes -> name: enseignant.notes.index
     */
    public function index(Request $request)
    {
        // Récupérer les IDs des classes enseignées par l'enseignant
        $classeIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->distinct('classe_id')
            ->pluck('classe_id');

        // Récupérer les IDs des évaluations de l'enseignant
        $evaluationIds = Evaluation::where('enseignant_id', $this->enseignant->id)
            ->pluck('id');

        // Requête de base pour les notes
        $query = Note::with(['eleve', 'eleve.classe', 'evaluation', 'evaluation.matiere'])
            ->whereIn('evaluation_id', $evaluationIds);

        // Filtres
        if ($request->filled('classe')) {
            $elevesDeClasse = Inscription::where('classe_id', $request->classe)
                ->where('statut', 'actif')
                ->pluck('eleve_id');
            $query->whereIn('eleve_id', $elevesDeClasse);
        }

        if ($request->filled('matiere')) {
            $evaluationsDeMatiere = Evaluation::where('matiere_id', $request->matiere)
                ->where('enseignant_id', $this->enseignant->id)
                ->pluck('id');
            $query->whereIn('evaluation_id', $evaluationsDeMatiere);
        }

        if ($request->filled('evaluation')) {
            $query->where('evaluation_id', $request->evaluation);
        }

        if ($request->filled('eleve')) {
            $query->whereHas('eleve', function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->eleve . '%')
                  ->orWhere('prenom', 'like', '%' . $request->eleve . '%');
            });
        }

        // Tri
        $query->orderBy('created_at', 'desc');

        // Pagination
        $notes = $query->paginate(15)->withQueryString();

        // Données pour les filtres et statistiques
        $classes = Classe::whereIn('id', $classeIds)->get();
        $matieres = Matiere::whereHas('enseignantMatiereClasses', function($q) {
            $q->where('enseignant_id', $this->enseignant->id);
        })->get();
        
        $evaluations = Evaluation::where('enseignant_id', $this->enseignant->id)
            ->with('matiere')
            ->get();

        // Statistiques
        $totalNotes = $notes->total();
        $moyenneGenerale = $query->avg('note') ?? 0;
        $classesCount = $classeIds->count();
        $evaluationsCount = $evaluations->count();

        return view('enseignant.notes', compact(
            'notes',
            'classes',
            'matieres',
            'evaluations',
            'totalNotes',
            'moyenneGenerale',
            'classesCount',
            'evaluationsCount'
        ));
    }

    /**
     * Affiche le formulaire de création de note
     * Route: GET /enseignant/notes/create -> name: enseignant.notes.create
     */
    public function create()
    {
        // Récupérer les évaluations de l'enseignant
        $evaluations = Evaluation::where('enseignant_id', $this->enseignant->id)
            ->with(['classe', 'matiere'])
            ->orderBy('date_evaluation', 'desc')
            ->get();

        // Si aucune évaluation, rediriger avec message
        if ($evaluations->isEmpty()) {
            return redirect()->route('enseignant.notes.index')
                ->with('error', 'Vous devez d\'abord créer une évaluation avant de saisir des notes.');
        }

        return view('enseignant.notes-create', compact('evaluations'));
    }

    /**
     * Enregistre une nouvelle note
     * Route: POST /enseignant/notes -> name: enseignant.notes.store
     */
    public function store(Request $request)
    {
        $request->validate([
            'evaluation_id' => 'required|exists:evaluations,id',
            'eleve_id' => 'required|exists:eleves,id',
            'note' => 'required|numeric|min:0|max:20',
            'observation' => 'nullable|string|max:255'
        ]);

        // Vérifier que l'évaluation appartient à l'enseignant
        $evaluation = Evaluation::where('id', $request->evaluation_id)
            ->where('enseignant_id', $this->enseignant->id)
            ->first();

        if (!$evaluation) {
            return back()->withErrors(['evaluation_id' => 'Cette évaluation ne vous appartient pas.'])->withInput();
        }

        // Vérifier que l'élève est dans la classe de l'évaluation
        $eleveDansClasse = Inscription::where('eleve_id', $request->eleve_id)
            ->where('classe_id', $evaluation->classe_id)
            ->where('statut', 'actif')
            ->exists();

        if (!$eleveDansClasse) {
            return back()->withErrors(['eleve_id' => "Cet élève n'est pas dans la classe de cette évaluation."])->withInput();
        }

        // Vérifier si une note existe déjà pour cet élève et cette évaluation
        $existe = Note::where('eleve_id', $request->eleve_id)
            ->where('evaluation_id', $request->evaluation_id)
            ->exists();

        if ($existe) {
            return back()->withErrors(['error' => 'Une note existe déjà pour cet élève et cette évaluation.'])->withInput();
        }

        try {
            Note::create([
                'eleve_id' => $request->eleve_id,
                'evaluation_id' => $request->evaluation_id,
                'note' => $request->note,
                'observation' => $request->observation
            ]);

            return redirect()->route('enseignant.notes.index')
                ->with('success', 'Note enregistrée avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'enregistrement.'])->withInput();
        }
    }

    /**
     * Affiche les détails d'une note
     * Route: GET /enseignant/notes/{id} -> name: enseignant.notes.show
     */
    public function show($id)
    {
        $note = Note::with(['eleve', 'eleve.classe', 'evaluation', 'evaluation.matiere'])
            ->findOrFail($id);

        // Vérifier que l'évaluation appartient à l'enseignant
        if ($note->evaluation->enseignant_id != $this->enseignant->id) {
            return redirect()->route('enseignant.notes.index')
                ->with('error', 'Vous n\'avez pas accès à cette note.');
        }

        return view('enseignant.notes-show', compact('note'));
    }

    /**
     * Affiche le formulaire d'édition
     * Route: GET /enseignant/notes/{id}/edit -> name: enseignant.notes.edit
     */
    public function edit($id)
    {
        $note = Note::with(['eleve', 'evaluation'])->findOrFail($id);

        // Vérifier que l'évaluation appartient à l'enseignant
        if ($note->evaluation->enseignant_id != $this->enseignant->id) {
            return redirect()->route('enseignant.notes.index')
                ->with('error', 'Vous n\'avez pas accès à cette note.');
        }

        $evaluations = Evaluation::where('enseignant_id', $this->enseignant->id)
            ->with(['classe', 'matiere'])
            ->orderBy('date_evaluation', 'desc')
            ->get();

        return view('enseignant.notes-edit', compact('note', 'evaluations'));
    }

    /**
     * Met à jour une note
     * Route: PUT /enseignant/notes/{id} -> name: enseignant.notes.update
     */
    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);

        // Vérifier que l'évaluation appartient à l'enseignant
        if ($note->evaluation->enseignant_id != $this->enseignant->id) {
            return redirect()->route('enseignant.notes.index')
                ->with('error', 'Vous n\'avez pas accès à cette note.');
        }

        $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'observation' => 'nullable|string|max:255'
        ]);

        try {
            $note->update([
                'note' => $request->note,
                'observation' => $request->observation
            ]);

            return redirect()->route('enseignant.notes.index')
                ->with('success', 'Note mise à jour avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour.'])->withInput();
        }
    }

    /**
     * Supprime une note
     * Route: DELETE /enseignant/notes/{id} -> name: enseignant.notes.destroy
     */
    public function destroy($id)
    {
        try {
            $note = Note::findOrFail($id);

            // Vérifier que l'évaluation appartient à l'enseignant
            if ($note->evaluation->enseignant_id != $this->enseignant->id) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Vous n\'avez pas accès à cette note.'
                    ], 403);
                }
                return redirect()->route('enseignant.notes.index')
                    ->with('error', 'Vous n\'avez pas accès à cette note.');
            }

            $note->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Note supprimée avec succès.'
                ]);
            }

            return redirect()->route('enseignant.notes.index')
                ->with('success', 'Note supprimée avec succès.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression.'
                ], 500);
            }

            return back()->with('error', 'Erreur lors de la suppression.');
        }
    }

    /**
     * Récupère les élèves d'une évaluation pour le formulaire
     * Route: GET /enseignant/notes/eleves/{evaluationId}
     */
    public function getElevesByEvaluation($evaluationId)
    {
        try {
            $evaluation = Evaluation::where('id', $evaluationId)
                ->where('enseignant_id', $this->enseignant->id)
                ->firstOrFail();

            $eleves = Eleve::whereHas('inscriptions', function($q) use ($evaluation) {
                $q->where('classe_id', $evaluation->classe_id)
                  ->where('statut', 'actif');
            })->select('id', 'nom', 'prenom', 'matricule')->get();

            // Exclure les élèves qui ont déjà une note pour cette évaluation
            $elevesAvecNotes = Note::where('evaluation_id', $evaluationId)
                ->pluck('eleve_id')
                ->toArray();

            $eleves = $eleves->filter(function($eleve) use ($elevesAvecNotes) {
                return !in_array($eleve->id, $elevesAvecNotes);
            })->values();

            return response()->json([
                'success' => true,
                'data' => $eleves,
                'bareme' => $evaluation->bareme ?? 20
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des élèves.'
            ], 500);
        }
    }

    /**
     * Saisie rapide des notes pour une évaluation
     * Route: GET /enseignant/notes/quick/{evaluation}
     */
    public function quick($evaluationId)
    {
        $evaluation = Evaluation::where('id', $evaluationId)
            ->where('enseignant_id', $this->enseignant->id)
            ->with(['classe', 'matiere'])
            ->firstOrFail();

        // Récupérer les élèves de la classe
        $eleves = Eleve::whereHas('inscriptions', function($q) use ($evaluation) {
            $q->where('classe_id', $evaluation->classe_id)
              ->where('statut', 'actif');
        })->orderBy('nom')->orderBy('prenom')->get();

        // Récupérer les notes existantes
        $notesExistantes = Note::where('evaluation_id', $evaluationId)
            ->get()
            ->keyBy('eleve_id');

        return view('enseignant.notes-quick', compact('evaluation', 'eleves', 'notesExistantes'));
    }

    /**
     * Enregistrement rapide des notes pour une évaluation
     * Route: POST /enseignant/notes/quick/{evaluation}
     */
    public function quickStore(Request $request, $evaluationId)
    {
        $evaluation = Evaluation::where('id', $evaluationId)
            ->where('enseignant_id', $this->enseignant->id)
            ->firstOrFail();

        $request->validate([
            'notes' => 'required|array',
            'notes.*' => 'nullable|numeric|min:0|max:' . ($evaluation->bareme ?? 20),
            'observations' => 'nullable|array'
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->notes as $eleveId => $noteValue) {
                if ($noteValue !== null && $noteValue !== '') {
                    Note::updateOrCreate(
                        [
                            'eleve_id' => $eleveId,
                            'evaluation_id' => $evaluationId
                        ],
                        [
                            'note' => $noteValue,
                            'observation' => $request->observations[$eleveId] ?? null
                        ]
                    );
                }
            }

            DB::commit();

            return redirect()->route('enseignant.notes.index')
                ->with('success', 'Notes enregistrées avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'enregistrement des notes.');
        }
    }

    /**
     * Export des notes en PDF/Excel
     * Route: GET /enseignant/notes/export/{evaluation}
     */
    public function export($evaluationId)
    {
        $evaluation = Evaluation::where('id', $evaluationId)
            ->where('enseignant_id', $this->enseignant->id)
            ->with(['classe', 'matiere'])
            ->firstOrFail();

        $notes = Note::where('evaluation_id', $evaluationId)
            ->with('eleve')
            ->orderBy('note', 'desc')
            ->get();

        // Logique d'export à implémenter selon vos besoins
        // (PDF, Excel, etc.)

        return view('enseignant.notes-export', compact('evaluation', 'notes'));
    }
}