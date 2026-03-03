<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Note;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Matiere;
use App\Models\Evaluation;
use App\Models\Inscription;

class NoteController extends Controller
{
    /**
     * Affiche la liste des notes avec filtres
     */
    public function index(Request $request)
    {
        $query = Note::with(['eleve', 'evaluation.matiere', 'evaluation.classe', 'evaluation.anneeScolaire']);

        // Filtre par année scolaire (via l'évaluation)
        if ($request->filled('annee_scolaire_id')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('annee_scolaire_id', $request->annee_scolaire_id);
            });
        }

        // Filtre par classe (via l'évaluation)
        if ($request->filled('classe_id')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('classe_id', $request->classe_id);
            });
        }

        // Filtre par élève
        if ($request->filled('eleve_id')) {
            $query->where('eleve_id', $request->eleve_id);
        }

        // Filtre par matière (via l'évaluation)
        if ($request->filled('matiere_id')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('matiere_id', $request->matiere_id);
            });
        }

        // Filtre par type d'évaluation
        if ($request->filled('type_evaluation')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('type', $request->type_evaluation);
            });
        }

        // Filtre par note (min/max)
        if ($request->filled('note_min')) {
            $query->where('note', '>=', $request->note_min);
        }
        if ($request->filled('note_max')) {
            $query->where('note', '<=', $request->note_max);
        }

        // Filtre par date d'évaluation
        if ($request->filled('date_debut')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->whereDate('date_evaluation', '>=', $request->date_debut);
            });
        }
        if ($request->filled('date_fin')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->whereDate('date_evaluation', '<=', $request->date_fin);
            });
        }

        // Statistiques
        $stats = [
            'total' => Note::count(),
            'moyenne_generale' => round(Note::avg('note') ?? 0, 2),
            'note_max' => Note::max('note') ?? 0,
            'note_min' => Note::min('note') ?? 0,
            'reussites' => Note::where('note', '>=', 10)->count(),
            'echecs' => Note::where('note', '<', 10)->count(),
        ];

        $notes = $query->orderBy('created_at', 'desc')
                      ->paginate(20)
                      ->withQueryString();

        // Données pour les filtres
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $typesEvaluation = ['devoir', 'examen', 'composition', 'interrogation'];

        return view('admin.notes.index', compact(
            'notes', 
            'anneeScolaires', 
            'classes', 
            'matieres',
            'typesEvaluation',
            'stats'
        ));
    }

    /**
     * Affiche les notes par classe (tableau de notes)
     */
    public function byClasse(Request $request)
    {
        $classeId = $request->get('classe_id');
        $anneeScolaireId = $request->get('annee_scolaire_id');
        $periode = $request->get('periode', 'Trimestre 1');
        $typeEvaluation = $request->get('type_evaluation');
        
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();
        $typesEvaluation = ['devoir', 'examen', 'composition', 'interrogation'];
        
        $eleves = [];
        $evaluations = [];
        $notesMatrice = [];
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
            
            // Récupérer les évaluations pour cette classe/période
            $evaluationsQuery = Evaluation::where('classe_id', $classeId)
                ->where('annee_scolaire_id', $anneeScolaireId)
                ->where('periode', $periode)
                ->with(['matiere']);
            
            if ($typeEvaluation) {
                $evaluationsQuery->where('type', $typeEvaluation);
            }
            
            $evaluations = $evaluationsQuery->orderBy('date_evaluation')->get();
            
            // Construire la matrice des notes
            foreach ($eleves as $eleve) {
                foreach ($evaluations as $evaluation) {
                    $note = Note::where('eleve_id', $eleve->id)
                        ->where('evaluation_id', $evaluation->id)
                        ->first();
                    
                    $notesMatrice[$eleve->id][$evaluation->id] = $note;
                }
            }
            
            // Statistiques par matière
            foreach ($evaluations->groupBy('matiere_id') as $matiereId => $evaluationsMatiere) {
                $matiere = $evaluationsMatiere->first()->matiere;
                $notesMatiere = Note::whereIn('evaluation_id', $evaluationsMatiere->pluck('id'))
                    ->get();
                
                $stats[$matiereId] = [
                    'matiere' => $matiere,
                    'moyenne' => round($notesMatiere->avg('note') ?? 0, 2),
                    'min' => round($notesMatiere->min('note') ?? 0, 2),
                    'max' => round($notesMatiere->max('note') ?? 0, 2),
                    'count' => $notesMatiere->count(),
                    'reussites' => $notesMatiere->where('note', '>=', 10)->count(),
                ];
            }
        }

        return view('admin.notes.by-classe', compact(
            'classes', 
            'anneeScolaires', 
            'eleves', 
            'evaluations',
            'notesMatrice',
            'stats',
            'classeId', 
            'anneeScolaireId', 
            'periode',
            'typeEvaluation',
            'typesEvaluation'
        ));
    }

    /**
     * Affiche les notes d'un élève
     */
    public function byEleve(Request $request, Eleve $eleve)
    {
        $anneeScolaireId = $request->get('annee_scolaire_id');
        $periode = $request->get('periode');
        $matiereId = $request->get('matiere_id');
        
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $periodes = ['Trimestre 1', 'Trimestre 2', 'Trimestre 3', 'Semestre 1', 'Semestre 2'];
        $matieres = Matiere::orderBy('nom')->get();
        
        $query = Note::where('eleve_id', $eleve->id)
            ->with(['evaluation.matiere', 'evaluation.classe']);
        
        if ($anneeScolaireId) {
            $query->whereHas('evaluation', function($q) use ($anneeScolaireId) {
                $q->where('annee_scolaire_id', $anneeScolaireId);
            });
        }
        
        if ($periode) {
            $query->whereHas('evaluation', function($q) use ($periode) {
                $q->where('periode', $periode);
            });
        }
        
        if ($matiereId) {
            $query->whereHas('evaluation', function($q) use ($matiereId) {
                $q->where('matiere_id', $matiereId);
            });
        }
        
        $notes = $query->orderBy('evaluation.date_evaluation', 'desc')
                      ->get()
                      ->groupBy(function($note) {
                          return $note->evaluation->matiere->nom ?? 'Sans matière';
                      });

        // Statistiques de l'élève
        $stats = [
            'total_notes' => $query->count(),
            'moyenne_generale' => round($query->avg('note') ?? 0, 2),
            'note_max' => round($query->max('note') ?? 0, 2),
            'note_min' => round($query->min('note') ?? 0, 2),
            'reussites' => (clone $query)->where('note', '>=', 10)->count(),
            'echecs' => (clone $query)->where('note', '<', 10)->count(),
        ];

        return view('admin.notes.by-eleve', compact(
            'eleve', 
            'notes', 
            'anneeScolaires',
            'periodes',
            'matieres',
            'anneeScolaireId',
            'periode',
            'matiereId',
            'stats'
        ));
    }

    /**
     * Affiche le formulaire de création de note
     */
    public function create()
    {
        $eleves = Eleve::orderBy('nom')->orderBy('prenom')->get();
        $evaluations = Evaluation::with(['classe', 'matiere'])->orderBy('date_evaluation', 'desc')->get();
        
        return view('admin.notes.create', compact('eleves', 'evaluations'));
    }

    /**
     * Enregistre une nouvelle note
     */
    public function store(Request $request)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'evaluation_id' => 'required|exists:evaluations,id',
            'note' => 'required|numeric|min:0|max:20',
            'observation' => 'nullable|string|max:500',
        ]);

        // Vérifier si une note existe déjà pour cet élève et cette évaluation
        $existingNote = Note::where('eleve_id', $request->eleve_id)
            ->where('evaluation_id', $request->evaluation_id)
            ->first();

        if ($existingNote) {
            return back()
                ->withInput()
                ->with('error', 'Une note existe déjà pour cet élève et cette évaluation.');
        }

        try {
            Note::create([
                'eleve_id' => $request->eleve_id,
                'evaluation_id' => $request->evaluation_id,
                'note' => $request->note,
                'observation' => $request->observation,
            ]);

            return redirect()
                ->route('admin.notes.index')
                ->with('success', 'Note ajoutée avec succès.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'ajout de la note.');
        }
    }

    /**
     * Affiche les détails d'une note
     */
    public function show(Note $note)
    {
        $note->load(['eleve', 'evaluation.matiere', 'evaluation.classe']);
        
        return view('admin.notes.show', compact('note'));
    }

    /**
     * Affiche le formulaire d'édition d'une note
     */
    public function edit(Note $note)
    {
        $note->load(['eleve', 'evaluation']);
        
        return view('admin.notes.edit', compact('note'));
    }

    /**
     * Met à jour une note
     */
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'observation' => 'nullable|string|max:500',
        ]);

        try {
            $note->update([
                'note' => $request->note,
                'observation' => $request->observation,
            ]);

            return redirect()
                ->route('admin.notes.show', $note)
                ->with('success', 'Note mise à jour avec succès.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }

    /**
     * Supprime une note
     */
    public function destroy(Note $note)
    {
        try {
            // Vérifier si la note est utilisée dans un bulletin
            if ($note->est_dans_bulletin) {
                return back()->with('error', 'Impossible de supprimer cette note car elle est utilisée dans un bulletin.');
            }

            $note->delete();

            return redirect()
                ->route('admin.notes.index')
                ->with('success', 'Note supprimée avec succès.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    /**
     * Import de notes (Excel/CSV)
     */
    public function import()
    {
        $evaluations = Evaluation::with(['matiere', 'classe'])
            ->orderBy('date_evaluation', 'desc')
            ->get();
        
        return view('admin.notes.import', compact('evaluations'));
    }

    /**
     * Traite l'import de notes
     */
    public function importStore(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:csv,xlsx,xls',
            'evaluation_id' => 'required|exists:evaluations,id',
        ]);

        try {
            // Logique d'import à implémenter
            // ...

            return redirect()
                ->route('admin.notes.by-classe')
                ->with('success', 'Notes importées avec succès.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erreur lors de l\'import : ' . $e->getMessage());
        }
    }

    /**
     * Export des notes
     */
    public function export(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'periode' => 'required|string',
        ]);

        try {
            // Logique d'export à implémenter (CSV, Excel)
            // ...

            return redirect()
                ->back()
                ->with('success', 'Export en cours de développement.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erreur lors de l\'export.');
        }
    }

    /**
     * API : Obtenir les notes d'un élève
     */
    public function getNotesEleve(Eleve $eleve, Request $request)
    {
        $query = Note::where('eleve_id', $eleve->id)
            ->with(['evaluation.matiere']);

        if ($request->filled('annee_scolaire_id')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('annee_scolaire_id', $request->annee_scolaire_id);
            });
        }

        if ($request->filled('periode')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('periode', $request->periode);
            });
        }

        $notes = $query->orderBy('evaluation.date_evaluation', 'desc')->get();

        return response()->json($notes);
    }

    /**
     * API : Obtenir les statistiques rapides
     */
    public function getQuickStats()
    {
        $stats = [
            'total' => Note::count(),
            'moyenne_generale' => round(Note::avg('note') ?? 0, 2),
            'note_max' => Note::max('note') ?? 0,
            'note_min' => Note::min('note') ?? 0,
            'reussites' => Note::where('note', '>=', 10)->count(),
            'echecs' => Note::where('note', '<', 10)->count(),
        ];

        return response()->json($stats);
    }
}