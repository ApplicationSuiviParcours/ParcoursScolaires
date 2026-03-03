<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bulletin;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Note;
use App\Models\Matiere;
use App\Models\Inscription;

class BulletinController extends Controller
{
    /**
     * Affiche la liste des bulletins avec filtres
     */
    public function index(Request $request)
    {
        $query = Bulletin::with(['eleve', 'classe', 'anneeScolaire']);

        // Filtre par année scolaire
        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        }

        // Filtre par classe
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        // Filtre par période
        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }

        // Filtre par élève
        if ($request->filled('eleve_id')) {
            $query->where('eleve_id', $request->eleve_id);
        }

        // Recherche par nom d'élève
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('eleve', function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        // Statistiques
        $stats = [
            'total' => Bulletin::count(),
            'par_periode' => Bulletin::select('periode', DB::raw('count(*) as total'))
                ->groupBy('periode')
                ->pluck('total', 'periode')
                ->toArray(),
            'moyenne_generale' => round(Bulletin::avg('moyenne_generale') ?? 0, 2),
            'admis' => Bulletin::where('moyenne_generale', '>=', 10)->count(),
        ];

        $bulletins = $query->orderBy('date_bulletin', 'desc')
                          ->orderBy('created_at', 'desc')
                          ->paginate(15)
                          ->withQueryString();

        // Données pour les filtres
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();
        $periodes = ['Trimestre 1', 'Trimestre 2', 'Trimestre 3', 'Semestre 1', 'Semestre 2', 'Annuel'];

        return view('admin.bulletins.index', compact(
            'bulletins', 
            'anneeScolaires', 
            'classes', 
            'periodes',
            'stats'
        ));
    }

    /**
     * Show the form for generating bulletins.
     */
    public function generate()
    {
        $anneeScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $classes = Classe::with(['inscriptions' => function($q) {
            $q->where('statut', true);
        }])->get();
        
        return view('admin.bulletins.generate', compact('anneeScolaires', 'classes'));
    }

    /**
     * Generate bulletins for a class and period.
     */
    public function generateStore(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'periode' => 'required|string|in:Trimestre 1,Trimestre 2,Trimestre 3,Semestre 1,Semestre 2,Annuel',
            'date_bulletin' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $classe = Classe::findOrFail($request->classe_id);
            $anneeScolaire = AnneeScolaire::findOrFail($request->annee_scolaire_id);
            
            // Récupérer tous les élèves de la classe pour cette année
            $inscriptions = Inscription::where('classe_id', $request->classe_id)
                ->where('annee_scolaire_id', $request->annee_scolaire_id)
                ->where('statut', true)
                ->with('eleve')
                ->get();

            if ($inscriptions->isEmpty()) {
                return back()
                    ->withInput()
                    ->with('error', 'Aucun élève inscrit dans cette classe pour l\'année sélectionnée.');
            }

            $bulletinsCreated = 0;
            $bulletinsUpdated = 0;
            $bulletinsData = [];

            // Calculer d'abord les moyennes pour tous les élèves
            foreach ($inscriptions as $inscription) {
                $eleve = $inscription->eleve;
                
                // Récupérer toutes les notes de l'élève pour la période
                $notes = Note::where('eleve_id', $eleve->id)
                    ->whereHas('evaluation', function($q) use ($request) {
                        $q->where('periode', $request->periode)
                          ->where('classe_id', $request->classe_id);
                    })
                    ->with(['evaluation.matiere'])
                    ->get();

                // Calculer la moyenne pondérée
                $totalPoints = 0;
                $totalCoefficients = 0;
                $notesParMatiere = [];

                foreach ($notes as $note) {
                    if ($note->evaluation && $note->evaluation->matiere) {
                        $matiereId = $note->evaluation->matiere->id;
                        $coefficient = $note->evaluation->coefficient ?? 1;
                        
                        if (!isset($notesParMatiere[$matiereId])) {
                            $notesParMatiere[$matiereId] = [
                                'total' => 0,
                                'coefficient' => $coefficient,
                                'count' => 0
                            ];
                        }
                        
                        $notesParMatiere[$matiereId]['total'] += $note->note;
                        $notesParMatiere[$matiereId]['count']++;
                        
                        $totalPoints += $note->note * $coefficient;
                        $totalCoefficients += $coefficient;
                    }
                }

                $moyenneGenerale = $totalCoefficients > 0 ? round($totalPoints / $totalCoefficients, 2) : 0;

                // Vérifier si le bulletin existe déjà
                $bulletin = Bulletin::where('eleve_id', $eleve->id)
                    ->where('classe_id', $request->classe_id)
                    ->where('annee_scolaire_id', $request->annee_scolaire_id)
                    ->where('periode', $request->periode)
                    ->first();

                $effectifClasse = $inscriptions->count();

                if ($bulletin) {
                    // Mise à jour du bulletin existant
                    $bulletin->update([
                        'moyenne_generale' => $moyenneGenerale,
                        'effectif_classe' => $effectifClasse,
                        'appreciation' => $this->getAppreciation($moyenneGenerale),
                        'date_bulletin' => $request->date_bulletin,
                    ]);
                    $bulletinsUpdated++;
                } else {
                    // Création d'un nouveau bulletin
                    $bulletinData = [
                        'eleve_id' => $eleve->id,
                        'classe_id' => $request->classe_id,
                        'annee_scolaire_id' => $request->annee_scolaire_id,
                        'periode' => $request->periode,
                        'moyenne_generale' => $moyenneGenerale,
                        'effectif_classe' => $effectifClasse,
                        'appreciation' => $this->getAppreciation($moyenneGenerale),
                        'date_bulletin' => $request->date_bulletin,
                    ];
                    
                    $bulletinsData[] = $bulletinData;
                }
            }

            // Créer les nouveaux bulletins
            if (!empty($bulletinsData)) {
                Bulletin::insert($bulletinsData);
                $bulletinsCreated = count($bulletinsData);
            }

            // Calculer les rangs après avoir créé tous les bulletins
            $this->calculerRangs($request->classe_id, $request->annee_scolaire_id, $request->periode);

            DB::commit();

            $message = [];
            if ($bulletinsCreated > 0) {
                $message[] = "{$bulletinsCreated} bulletin(s) créé(s)";
            }
            if ($bulletinsUpdated > 0) {
                $message[] = "{$bulletinsUpdated} bulletin(s) mis à jour";
            }

            return redirect()
                ->route('admin.bulletins.index')
                ->with('success', implode(' et ', $message) . ' avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la génération des bulletins : ' . $e->getMessage());
        }
    }

    /**
     * Calcule les rangs pour tous les bulletins d'une classe/période
     */
    private function calculerRangs($classeId, $anneeScolaireId, $periode)
    {
        $bulletins = Bulletin::where('classe_id', $classeId)
            ->where('annee_scolaire_id', $anneeScolaireId)
            ->where('periode', $periode)
            ->orderBy('moyenne_generale', 'desc')
            ->get();

        $rang = 1;
        $moyennePrecedente = null;
        $rangPrecedent = 1;

        foreach ($bulletins as $index => $bulletin) {
            if ($moyennePrecedente !== null && $bulletin->moyenne_generale == $moyennePrecedente) {
                // Ex aequo - même rang
                $bulletin->rang = $rangPrecedent;
            } else {
                // Nouveau rang
                $bulletin->rang = $index + 1;
                $rangPrecedent = $index + 1;
            }
            
            $bulletin->save();
            $moyennePrecedente = $bulletin->moyenne_generale;
        }
    }

    /**
     * Display the specified bulletin - DEBUG VERSION
     */
    public function showDebug(Bulletin $bulletin)
    {
        $bulletin->load([
            'eleve',
            'classe',
            'anneeScolaire'
        ]);

        // Debug: Afficher les infos du bulletin
        $debugInfo = [
            'bulletin_id' => $bulletin->id,
            'eleve_id' => $bulletin->eleve_id,
            'classe_id' => $bulletin->classe_id,
            'annee_scolaire_id' => $bulletin->annee_scolaire_id,
            'periode' => $bulletin->periode,
        ];

        // Récupérer les notes avec debug
        $notes = Note::where('eleve_id', $bulletin->eleve_id)
            ->whereHas('evaluation', function($q) use ($bulletin) {
                $q->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
                  ->where('classe_id', $bulletin->classe_id)
                  ->where('periode', $bulletin->periode);
            })
            ->with(['evaluation.matiere', 'evaluation.classe'])
            ->get();
        
        $debugInfo['notes_count'] = $notes->count();
        
        // Afficher les détails de chaque note
        $notesDetails = [];
        foreach ($notes as $note) {
            $notesDetails[] = [
                'note_id' => $note->id,
                'note_value' => $note->note,
                'evaluation_id' => $note->evaluation_id,
                'evaluation_periode' => $note->evaluation?->periode,
                'evaluation_classe_id' => $note->evaluation?->classe_id,
                'matiere_id' => $note->evaluation?->matiere_id,
                'matiere_nom' => $note->evaluation?->matiere?->nom,
            ];
        }
        
        $debugInfo['notes_details'] = $notesDetails;

        return response()->json($debugInfo);
    }

    /**
     * Display the specified bulletin.
     */
    public function show(Bulletin $bulletin)
    {
        $bulletin->load([
            'eleve',
            'classe',
            'anneeScolaire'
        ]);

        // Récupérer les notes de l'élève pour la période du bulletin directement depuis les évaluations
        // On cherche les notes de l'élève pour la même année scolaire, classe et période que le bulletin
        $notes = Note::where('eleve_id', $bulletin->eleve_id)
            ->whereHas('evaluation', function($q) use ($bulletin) {
                $q->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
                  ->where('classe_id', $bulletin->classe_id)
                  ->where('periode', $bulletin->periode);
            })
            ->with(['evaluation.matiere', 'evaluation.classe'])
            ->get();
        
        // Organiser les notes par matière
        $notesParMatiere = [];
        
        // Grouper par matière en utilisant l'ID de la matière depuis l'évaluation
        $groupedNotes = $notes->groupBy(function($note) {
            return $note->evaluation?->matiere?->id ?? 'inconnu';
        });
        
        foreach ($groupedNotes as $matiereId => $matiereNotes) {
            if ($matiereId === 'inconnu' || $matiereId === null) {
                continue;
            }
            
            $firstNote = $matiereNotes->first();
            $matiere = $firstNote?->evaluation?->matiere;
            
            if (!$matiere) {
                continue;
            }
            
            $totalPoints = 0;
            $totalCoeffs = 0;
            
            foreach ($matiereNotes as $note) {
                $coeff = $note->evaluation?->coefficient ?? 1;
                $totalPoints += $note->note * $coeff;
                $totalCoeffs += $coeff;
            }
            
            $notesParMatiere[$matiereId] = [
                'matiere' => $matiere,
                'matiere_nom' => $matiere->nom,
                'matiere_code' => $matiere->code ?? '',
                'notes' => $matiereNotes,
                'coefficient' => $totalCoeffs,
                'coefficient_total' => $totalCoeffs,
                'moyenne' => $totalCoeffs > 0 ? round($totalPoints / $totalCoeffs, 2) : 0,
                'moyenne_ponderee' => $totalCoeffs > 0 ? round($totalPoints / $totalCoeffs, 2) : 0,
            ];
        }
        
        // Statistiques
        $stats = [
            'total_notes' => $notes->count(),
            'moyenne' => $bulletin->moyenne_generale,
            'rang' => $bulletin->rang,
            'effectif' => $bulletin->effectif_classe,
            'mention' => $bulletin->mention,
            'est_admis' => $bulletin->est_admis,
        ];

        return view('admin.bulletins.show', compact('bulletin', 'notesParMatiere', 'stats'));
    }

    /**
     * Show the form for editing the specified bulletin.
     */
    public function edit(Bulletin $bulletin)
    {
        $bulletin->load(['eleve', 'classe', 'anneeScolaire', 'notesBulletin']);
        
        $periodes = ['Trimestre 1', 'Trimestre 2', 'Trimestre 3', 'Semestre 1', 'Semestre 2', 'Annuel'];
        
        return view('admin.bulletins.edit', compact('bulletin', 'periodes'));
    }

    /**
     * Update the specified bulletin in storage.
     */
    public function update(Request $request, Bulletin $bulletin)
    {
        $request->validate([
            'periode' => 'required|string',
            'moyenne_generale' => 'required|numeric|min:0|max:20',
            'rang' => 'nullable|integer|min:1',
            'appreciation' => 'nullable|string|max:500',
            'date_bulletin' => 'required|date',
        ]);

        try {
            $bulletin->update([
                'periode' => $request->periode,
                'moyenne_generale' => $request->moyenne_generale,
                'rang' => $request->rang,
                'appreciation' => $request->appreciation,
                'date_bulletin' => $request->date_bulletin,
            ]);

            return redirect()
                ->route('admin.bulletins.show', $bulletin)
                ->with('success', 'Bulletin mis à jour avec succès.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du bulletin.');
        }
    }

    /**
     * Remove the specified bulletin from storage.
     */
    public function destroy(Bulletin $bulletin)
    {
        try {
            // Supprimer les associations avec les notes (si nécessaire)
            $bulletin->notesBulletin()->detach();
            
            $bulletin->delete();

            return redirect()
                ->route('admin.bulletins.index')
                ->with('success', 'Bulletin supprimé avec succès.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Une erreur est survenue lors de la suppression du bulletin.');
        }
    }

    /**
     * Get appreciation based on average.
     */
    private function getAppreciation($moyenne)
    {
        if ($moyenne >= 16) return "Excellent travail, félicitations !";
        if ($moyenne >= 14) return "Très bien, continuez ainsi !";
        if ($moyenne >= 12) return "Bien, peut mieux faire.";
        if ($moyenne >= 10) return "Passable, des efforts sont nécessaires.";
        return "Insuffisant, un travail plus soutenu est requis.";
    }

    /**
     * API: Obtenir les statistiques rapides
     */
    public function getQuickStats()
    {
        $stats = [
            'total' => Bulletin::count(),
            'moyenne_generale' => round(Bulletin::avg('moyenne_generale') ?? 0, 2),
            'admis' => Bulletin::where('moyenne_generale', '>=', 10)->count(),
            'par_periode' => Bulletin::select('periode', DB::raw('count(*) as total'))
                ->groupBy('periode')
                ->get(),
        ];

        return response()->json($stats);
    }

    /**
     * API: Obtenir les bulletins pour un élève
     */
    public function getForEleve(Eleve $eleve)
    {
        $bulletins = $eleve->bulletins()
            ->with(['classe', 'anneeScolaire'])
            ->orderBy('date_bulletin', 'desc')
            ->get();

        return response()->json($bulletins);
    }

    /**
     * Imprimer un bulletin
     */
    public function print(Bulletin $bulletin)
    {
        // Charger toutes les relations nécessaires
        $bulletin->load([
            'eleve',
            'classe',
            'anneeScolaire',
            'notesBulletin' => function($query) {
                $query->with(['evaluation' => function($q) {
                    $q->with('matiere');
                }]);
            }
        ]);

        // Organiser les notes par matière
        $notesParMatiere = [];
        $totalPoints = 0;
        $totalCoeffs = 0;
        
        foreach ($bulletin->notesBulletin as $note) {
            if ($note->evaluation && $note->evaluation->matiere) {
                $matiereId = $note->evaluation->matiere->id;
                $matiereNom = $note->evaluation->matiere->nom;
                $coefficient = $note->pivot->coefficient ?? $note->evaluation->coefficient ?? 1;
                
                if (!isset($notesParMatiere[$matiereId])) {
                    $notesParMatiere[$matiereId] = [
                        'matiere_id' => $matiereId,
                        'matiere_nom' => $matiereNom,
                        'matiere_code' => $note->evaluation->matiere->code,
                        'notes' => [],
                        'total' => 0,
                        'count' => 0,
                        'coefficient' => $coefficient,
                        'total_pondere' => 0
                    ];
                }
                
                $notesParMatiere[$matiereId]['notes'][] = [
                    'id' => $note->id,
                    'valeur' => $note->note,
                    'evaluation' => $note->evaluation->nom,
                    'date' => $note->evaluation->date_evaluation->format('d/m/Y'),
                    'coefficient' => $coefficient,
                    'appreciation' => $note->pivot->appreciation ?? null,
                ];
                
                $notesParMatiere[$matiereId]['total'] += $note->note;
                $notesParMatiere[$matiereId]['total_pondere'] += $note->note * $coefficient;
                $notesParMatiere[$matiereId]['count']++;
                
                $totalPoints += $note->note * $coefficient;
                $totalCoeffs += $coefficient;
            }
        }

        // Calculer les moyennes par matière
        foreach ($notesParMatiere as &$data) {
            if ($data['count'] > 0) {
                $data['moyenne_simple'] = round($data['total'] / $data['count'], 2);
                $data['moyenne_ponderee'] = round($data['total_pondere'] / $data['count'], 2);
                $data['moyenne'] = $data['moyenne_ponderee']; // Utiliser la moyenne pondérée par défaut
            }
        }

        // Trier par nom de matière
        uasort($notesParMatiere, function($a, $b) {
            return strcmp($a['matiere_nom'], $b['matiere_nom']);
        });

        $moyenneGenerale = $totalCoeffs > 0 ? round($totalPoints / $totalCoeffs, 2) : 0;

        return view('admin.bulletins.print', compact(
            'bulletin', 
            'notesParMatiere', 
            'moyenneGenerale', 
            'totalPoints', 
            'totalCoeffs'
        ));
    }
}
