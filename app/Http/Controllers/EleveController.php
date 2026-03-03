<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Eleve;
use App\Models\Note;
use App\Models\Absence;
use App\Models\Bulletin;
use App\Models\EmploiDuTemps;
use App\Models\Inscription;
use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\ParentEleve;
use App\Models\Evaluation;
use Barryvdh\DomPDF\Facade\Pdf;

class EleveController extends Controller
{
    /**
     * Middleware pour s'assurer que l'utilisateur est connecté
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vérifie et récupère l'élève connecté
     */
    private function getEleveConnecte()
    {
        $user = Auth::user();
        
        if (!$user) {
            return null;
        }

        $eleve = $user->eleve;

        if (app()->environment('local') && !$eleve) {
            Log::info('Utilisateur ' . $user->id . ' a le rôle élève mais pas de profil élève associé');
        }

        return $eleve;
    }

    /**
     * Récupère la classe actuelle de l'élève via la dernière inscription
     */
    private function getClasseActuelle($eleve)
    {
        if (!$eleve) {
            return null;
        }
        
        $derniereInscription = Inscription::where('eleve_id', $eleve->id)
            ->where('statut', true)
            ->with('classe')
            ->latest()
            ->first();
            
        return $derniereInscription?->classe;
    }

    /**
     * Récupère l'inscription actuelle de l'élève
     */
    private function getInscriptionActuelle($eleve)
    {
        if (!$eleve) {
            return null;
        }
        
        return Inscription::where('eleve_id', $eleve->id)
            ->where('statut', true)
            ->with('classe.anneeScolaire')
            ->latest()
            ->first();
    }

    /**
     * Affiche le tableau de bord de l'élève connecté
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Debug: Vérifier l'utilisateur et la relation
        Log::info('EleveController dashboard - User ID: ' . $user->id);
        Log::info('EleveController dashboard - User name: ' . $user->name);
        Log::info('EleveController dashboard - Eleve relation exists: ' . ($user->eleve ? 'yes' : 'no'));
        
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return view('eleve.dashboard', [
                'eleve' => null,
                'anneeScolaire' => null,
                'inscription' => null,
                'notes' => collect([]),
                'moyenneGenerale' => null,
                'dernieresNotes' => collect([]),
                'absences' => collect([]),
                'absencesNonJustifiees' => 0,
                'absencesJustifiees' => 0,
                'bulletins' => collect([]),
                'bulletinCourant' => null,
                'emploiDuTemps' => collect([]),
                'moyennesParMatiere' => [],
                'stats' => [
                    'moyenne_generale' => null,
                    'total_notes' => 0,
                    'total_absences' => 0,
                    'absences_justifiees' => 0,
                    'absences_non_justifiees' => 0,
                    'total_bulletins' => 0,
                    'matieres_evaluees' => 0,
                    'classe_actuelle' => 'Aucune',
                ],
                'classeActuelle' => null,
                'error' => 'Aucun profil élève associé à votre compte. Veuillez contacter l\'administration.'
            ]);
        }

        // MODIFICATION: Ne pas charger 'classe' directement
        $eleve->load(['inscriptions.classe', 'parents']);
        
        $anneeScolaire = AnneeScolaire::where('active', true)->first();

        // Utiliser la méthode pour récupérer l'inscription
        $inscription = $this->getInscriptionActuelle($eleve);

        $notes = Note::where('eleve_id', $eleve->id)
            ->with(['evaluation.matiere', 'evaluation.classe'])
            ->orderByDesc('created_at')
            ->get();

        $moyenneGenerale = $notes->avg('note');
        $dernieresNotes = $notes->take(5);

        $absences = Absence::where('eleve_id', $eleve->id)
            ->with('matiere')
            ->orderBy('date_absence', 'desc')
            ->get();

        $absencesNonJustifiees = $absences->where('justifiee', false)->count();
        $absencesJustifiees = $absences->where('justifiee', true)->count();

        $bulletins = Bulletin::where('eleve_id', $eleve->id)
            ->with('classe')
            ->orderBy('periode', 'desc')
            ->get();

        $bulletinCourant = $bulletins->first();

        // Récupérer la classe actuelle pour l'emploi du temps
        $classeActuelle = $this->getClasseActuelle($eleve);

        $emploiDuTemps = collect([]);
        if ($classeActuelle) {
            $emploiDuTemps = EmploiDuTemps::where('classe_id', $classeActuelle->id)
                ->with(['matiere', 'enseignant'])
                ->orderBy('jour')
                ->orderBy('heure_debut')
                ->get();
        }

        $notesParMatiere = [];
        foreach ($notes as $note) {
            if ($note->evaluation && $note->evaluation->matiere) {
                $matiereId = $note->evaluation->matiere->id;
                $matiereNom = $note->evaluation->matiere->nom;
                $coefficient = $note->evaluation->matiere->coefficient ?? 1;
                
                if (!isset($notesParMatiere[$matiereId])) {
                    $notesParMatiere[$matiereId] = [
                        'id' => $matiereId,
                        'nom' => $matiereNom,
                        'coefficient' => $coefficient,
                        'notes' => collect(),
                        'sommeNotes' => 0,
                        'sommeCoefficients' => 0
                    ];
                }
                $notesParMatiere[$matiereId]['notes']->push($note);
                $notesParMatiere[$matiereId]['sommeNotes'] += $note->note * $coefficient;
                $notesParMatiere[$matiereId]['sommeCoefficients'] += $coefficient;
            }
        }

        $moyennesParMatiere = [];
        foreach ($notesParMatiere as $matiereId => $data) {
            if ($data['sommeCoefficients'] > 0) {
                $moyennesParMatiere[$matiereId] = [
                    'id' => $data['id'],
                    'nom' => $data['nom'],
                    'coefficient' => $data['coefficient'],
                    'moyenne' => round($data['sommeNotes'] / $data['sommeCoefficients'], 2),
                    'nombreNotes' => $data['notes']->count()
                ];
            }
        }

        $stats = [
            'moyenne_generale' => $moyenneGenerale ? round($moyenneGenerale, 2) : null,
            'total_notes' => $notes->count(),
            'total_absences' => $absences->count(),
            'absences_justifiees' => $absencesJustifiees,
            'absences_non_justifiees' => $absencesNonJustifiees,
            'total_bulletins' => $bulletins->count(),
            'matieres_evaluees' => $moyennesParMatiere ? count($moyennesParMatiere) : 0,
            'classe_actuelle' => $classeActuelle ? $classeActuelle->nom . ' (' . $classeActuelle->niveau . ')' : 'Aucune',
        ];

        return view('eleve.dashboard', compact(
            'eleve',
            'anneeScolaire',
            'inscription',
            'notes',
            'moyenneGenerale',
            'dernieresNotes',
            'absences',
            'absencesNonJustifiees',
            'absencesJustifiees',
            'bulletins',
            'bulletinCourant',
            'emploiDuTemps',
            'moyennesParMatiere',
            'stats',
            'classeActuelle'
        ));
    }

    /**
     * Affiche les notes de l'élève connecté
     */
    public function mesNotes(Request $request)
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return redirect()->route('eleve.dashboard')
                ->with('error', 'Aucun profil élève associé à votre compte.');
        }

        // MODIFICATION: Ne pas charger 'classe' directement
        // $eleve->load(['classe']); // À supprimer

        $query = Note::where('eleve_id', $eleve->id)
            ->with(['evaluation.matiere', 'evaluation.classe']);

        if ($request->filled('matiere_id')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('matiere_id', $request->matiere_id);
            });
        }

        if ($request->filled('periode')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('periode', $request->periode);
            });
        }

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

        $notes = $query->orderByDesc(
                Evaluation::select('date_evaluation')
                    ->whereColumn('evaluations.id', 'notes.evaluation_id')
            )
            ->orderByDesc('notes.created_at')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'moyenne_generale' => round($notes->avg('note') ?? 0, 2),
            'note_min' => $notes->min('note') ?? 0,
            'note_max' => $notes->max('note') ?? 0,
            'total_notes' => $notes->total(),
        ];

        $matieres = Matiere::orderBy('nom')->get();
        $periodes = ['trimestre1', 'trimestre2', 'trimestre3'];

        return view('eleve.notes', compact('notes', 'eleve', 'stats', 'matieres', 'periodes'));
    }

    /**
     * Affiche les détails d'une note spécifique
     */
    public function detailNote(Note $note)
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve || $note->eleve_id != $eleve->id) {
            return redirect()->route('eleve.notes')
                ->with('error', 'Vous n\'avez pas accès à cette note.');
        }

        $note->load(['evaluation.matiere', 'evaluation.classe']);

        $autresNotes = Note::where('eleve_id', $eleve->id)
            ->whereHas('evaluation', function($q) use ($note) {
                $q->where('matiere_id', $note->evaluation->matiere_id);
            })
            ->with('evaluation')
            ->orderByDesc(
                Evaluation::select('date_evaluation')
                    ->whereColumn('evaluations.id', 'notes.evaluation_id')
            )
            ->limit(5)
            ->get();

        return view('eleve.note-detail', compact('note', 'eleve', 'autresNotes'));
    }

    /**
     * Affiche les absences de l'élève connecté
     */
    public function mesAbsences(Request $request)
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return redirect()->route('eleve.dashboard')
                ->with('error', 'Aucun profil élève associé à ce compte.');
        }

        // MODIFICATION: Ne pas charger 'classe' directement
        // $eleve->load(['classe']); // À supprimer

        $query = Absence::where('eleve_id', $eleve->id)
            ->with('matiere');

        if ($request->filled('justifiee')) {
            $query->where('justifiee', $request->justifiee);
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('date_absence', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('date_absence', '<=', $request->date_fin);
        }

        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        $absences = $query->orderBy('date_absence', 'desc')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total' => Absence::where('eleve_id', $eleve->id)->count(),
            'justifiees' => Absence::where('eleve_id', $eleve->id)->where('justifiee', true)->count(),
            'non_justifiees' => Absence::where('eleve_id', $eleve->id)->where('justifiee', false)->count(),
            'mois_courant' => Absence::where('eleve_id', $eleve->id)
                ->whereMonth('date_absence', now()->month)
                ->count(),
        ];

        $matieres = Matiere::orderBy('nom')->get();

        return view('eleve.absences', compact('absences', 'eleve', 'stats', 'matieres'));
    }

    /**
     * Affiche le bulletin de l'élève connecté - VERSION CORRIGÉE
     */
    public function monBulletin(Request $request)
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return redirect()->route('eleve.dashboard')
                ->with('error', 'Aucun profil élève associé à ce compte.');
        }

        // Récupérer les bulletins
        $query = Bulletin::where('eleve_id', $eleve->id)
            ->with(['classe', 'anneeScolaire']);

        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }

        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        }

        $bulletins = $query->orderBy('periode', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Pour chaque bulletin, récupérer les notes directement depuis les évaluations
        foreach ($bulletins as $bulletin) {
            $notes = Note::where('eleve_id', $bulletin->eleve_id)
                ->whereHas('evaluation', function($q) use ($bulletin) {
                    $q->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
                      ->where('classe_id', $bulletin->classe_id)
                      ->where('periode', $bulletin->periode);
                })
                ->with(['evaluation.matiere', 'evaluation.classe'])
                ->get();
            
            // Stocker les notes dans une propriété temporaire pour la vue
            $bulletin->setAttribute('notesDirectes', $notes);
        }

        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $periodes = ['trimestre1', 'trimestre2', 'trimestre3', 'semestre1', 'semestre2'];

        return view('eleve.bulletin', compact('bulletins', 'eleve', 'anneesScolaires', 'periodes'));
    }

    /**
     * Affiche les détails d'un bulletin spécifique - VERSION CORRIGÉE
     * Récupère les notes directement depuis les évaluations
     */
    public function detailBulletin(Bulletin $bulletin)
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve || $bulletin->eleve_id != $eleve->id) {
            return redirect()->route('eleve.bulletins')
                ->with('error', 'Vous n\'avez pas accès à ce bulletin.');
        }

        // Charger le bulletin avec ses relations de base
        $bulletin->load([
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

        // Calculer les moyennes par matière à partir des notes récupérées
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

        // Calculer la moyenne générale pondérée
        $totalPoints = 0;
        $totalCoeffs = 0;
        
        foreach ($notes as $note) {
            $coeff = $note->evaluation?->coefficient ?? 1;
            $totalPoints += $note->note * $coeff;
            $totalCoeffs += $coeff;
        }
        
        $moyenneGenerale = $totalCoeffs > 0 ? round($totalPoints / $totalCoeffs, 2) : 0;

        return view('eleve.bulletin-detail', compact('bulletin', 'eleve', 'notesParMatiere', 'moyenneGenerale'));
    }

    /**
     * Affiche l'emploi du temps de l'élève
     */
    public function emploiDuTemps(Request $request)
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return redirect()->route('eleve.dashboard')
                ->with('error', 'Aucun profil élève associé à ce compte.');
        }

        // MODIFICATION: Utiliser les méthodes helper
        $classeActuelle = $this->getClasseActuelle($eleve);
        $inscription = $this->getInscriptionActuelle($eleve);

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        if (!$classeActuelle) {
            return view('eleve.emploi-du-temps', [
                'eleve' => $eleve,
                'emploiDuTemps' => collect([]),
                'emploiParJour' => [],
                'classeActuelle' => null,
                'inscription' => null,
                'jours' => $jours,
                'message' => 'Vous n\'êtes pas inscrit dans une classe active.'
            ]);
        }

        $query = EmploiDuTemps::where('classe_id', $classeActuelle->id)
            ->with(['matiere', 'enseignant']);

        if ($request->filled('jour')) {
            $query->where('jour', $request->jour);
        }

        $emploiDuTemps = $query->orderBy('jour')
            ->orderBy('heure_debut')
            ->get();

        $emploiParJour = [];
        foreach ($jours as $jour) {
            $emploiParJour[$jour] = $emploiDuTemps->filter(function($cours) use ($jour) {
                return $cours->jour == $jour;
            })->values();
        }

        return view('eleve.emploi-du-temps', compact(
            'emploiDuTemps', 
            'emploiParJour', 
            'eleve', 
            'classeActuelle',
            'inscription',
            'jours'
        ));
    }

    /**
     * Affiche le profil complet de l'élève
     */
    public function profil()
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return redirect()->route('login')
                ->with('error', 'Aucun profil élève associé à ce compte.');
        }

        // MODIFICATION: Ne pas charger 'classe' directement
        $eleve->load([
            'inscriptions' => function($q) {
                $q->with(['classe.anneeScolaire'])->latest();
            },
            'parents',
            'notes' => function($q) {
                $q->with(['evaluation.matiere'])->latest()->take(20);
            },
            'absences' => function($q) {
                $q->with(['matiere'])->latest();
            },
            'bulletins' => function($q) {
                $q->with(['classe', 'anneeScolaire'])->latest();
            }
        ]);

        $age = $eleve->date_naissance->age;
        $classeActuelle = $this->getClasseActuelle($eleve);

        $stats = [
            'age' => $age,
            'moyenne_notes' => $eleve->notes->avg('note'),
            'total_absences' => $eleve->absences->count(),
            'absences_justifiees' => $eleve->absences->where('justifiee', true)->count(),
            'absences_non_justifiees' => $eleve->absences->where('justifiee', false)->count(),
            'total_inscriptions' => $eleve->inscriptions->count(),
            'total_parents' => $eleve->parents->count(),
            'total_bulletins' => $eleve->bulletins->count(),
            'classe_actuelle' => $classeActuelle ? $classeActuelle->nom . ' (' . $classeActuelle->niveau . ')' : 'Non assigné',
        ];

        return view('eleve.profil', compact('eleve', 'age', 'stats', 'classeActuelle'));
    }

    /**
     * Affiche le calendrier des absences
     */
    public function calendrierAbsences(Request $request)
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return redirect()->route('login')
                ->with('error', 'Aucun profil élève associé à ce compte.');
        }

        $mois = $request->get('mois', now()->month);
        $annee = $request->get('annee', now()->year);

        $absences = Absence::where('eleve_id', $eleve->id)
            ->with('matiere')
            ->whereYear('date_absence', $annee)
            ->whereMonth('date_absence', $mois)
            ->orderBy('date_absence')
            ->get();

        $stats = [
            'total' => $absences->count(),
            'justifiees' => $absences->where('justifiee', true)->count(),
            'non_justifiees' => $absences->where('justifiee', false)->count(),
        ];

        return view('eleve.calendrier-absences', compact('eleve', 'absences', 'stats', 'mois', 'annee'));
    }

    /**
     * Affiche le relevé de notes par matière
     */
    public function releveNotes(Request $request)
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return redirect()->route('login')
                ->with('error', 'Aucun profil élève associé à ce compte.');
        }

        $periode = $request->get('periode', 'trimestre1');

        $notes = Note::where('eleve_id', $eleve->id)
            ->with(['evaluation.matiere', 'evaluation.classe'])
            ->whereHas('evaluation', function($q) use ($periode) {
                $q->where('periode', $periode);
            })
            ->get();

        $notesParMatiere = [];
        foreach ($notes as $note) {
            if ($note->evaluation && $note->evaluation->matiere) {
                $matiereId = $note->evaluation->matiere->id;
                if (!isset($notesParMatiere[$matiereId])) {
                    $notesParMatiere[$matiereId] = [
                        'matiere' => $note->evaluation->matiere,
                        'notes' => collect(),
                        'total' => 0,
                        'count' => 0
                    ];
                }
                $notesParMatiere[$matiereId]['notes']->push($note);
                $notesParMatiere[$matiereId]['total'] += $note->note;
                $notesParMatiere[$matiereId]['count']++;
            }
        }

        $moyennes = [];
        foreach ($notesParMatiere as $matiereId => $data) {
            $moyennes[$matiereId] = [
                'matiere' => $data['matiere'],
                'moyenne' => $data['count'] > 0 ? round($data['total'] / $data['count'], 2) : 0,
                'nombre_notes' => $data['count']
            ];
        }

        $moyenneGenerale = $notes->avg('note');
        $periodes = ['trimestre1', 'trimestre2', 'trimestre3', 'semestre1', 'semestre2'];

        return view('eleve.releve-notes', compact('eleve', 'notesParMatiere', 'moyennes', 'moyenneGenerale', 'periode', 'periodes'));
    }

    // ============ MÉTHODES D'EXPORT PDF ============

    /**
     * Exporter les notes au format PDF
     */
    public function exportNotesPdf(Request $request)
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return redirect()->route('login')
                ->with('error', 'Aucun profil élève associé à ce compte.');
        }

        // MODIFICATION: Récupérer la classe actuelle
        $classeActuelle = $this->getClasseActuelle($eleve);

        $query = Note::where('eleve_id', $eleve->id)
            ->with(['evaluation.matiere', 'evaluation.classe']);

        if ($request->filled('matiere_id')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('matiere_id', $request->matiere_id);
            });
        }

        if ($request->filled('periode')) {
            $query->whereHas('evaluation', function($q) use ($request) {
                $q->where('periode', $request->periode);
            });
        }

        $notes = $query->orderByDesc(
                Evaluation::select('date_evaluation')
                    ->whereColumn('evaluations.id', 'notes.evaluation_id')
            )
            ->get();

        $stats = [
            'moyenne' => $notes->avg('note'),
            'min' => $notes->min('note'),
            'max' => $notes->max('note'),
            'total' => $notes->count()
        ];

        $pdf = Pdf::loadView('eleve.exports.notes-pdf', compact('eleve', 'classeActuelle', 'notes', 'stats'));

        return $pdf->download('mes_notes_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exporter les absences au format PDF
     */
    public function exportAbsencesPdf(Request $request)
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return redirect()->route('login')
                ->with('error', 'Aucun profil élève associé à ce compte.');
        }

        // MODIFICATION: Récupérer la classe actuelle
        $classeActuelle = $this->getClasseActuelle($eleve);

        $query = Absence::where('eleve_id', $eleve->id)
            ->with('matiere');

        if ($request->filled('justifiee')) {
            $query->where('justifiee', $request->justifiee);
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('date_absence', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('date_absence', '<=', $request->date_fin);
        }

        $absences = $query->orderBy('date_absence', 'desc')->get();

        $stats = [
            'total' => $absences->count(),
            'justifiees' => $absences->where('justifiee', true)->count(),
            'non_justifiees' => $absences->where('justifiee', false)->count()
        ];

        $pdf = Pdf::loadView('eleve.exports.absences-pdf', compact('eleve', 'classeActuelle', 'absences', 'stats'));

        return $pdf->download('mes_absences_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exporter un bulletin au format PDF
     */
    public function exportBulletinPdf(Bulletin $bulletin)
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve || $bulletin->eleve_id != $eleve->id) {
            return redirect()->route('eleve.bulletins')
                ->with('error', 'Vous n\'avez pas accès à ce bulletin.');
        }

        $bulletin->load([
            'classe', 
            'anneeScolaire'
        ]);

        // Récupérer les notes directement depuis les évaluations
        $notes = Note::where('eleve_id', $bulletin->eleve_id)
            ->whereHas('evaluation', function($q) use ($bulletin) {
                $q->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
                  ->where('classe_id', $bulletin->classe_id)
                  ->where('periode', $bulletin->periode);
            })
            ->with(['evaluation.matiere', 'evaluation.classe'])
            ->get();

        // Calculer les moyennes par matière
        $notesParMatiere = [];
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
                'notes' => $matiereNotes,
                'total' => $totalPoints,
                'coefficient_total' => $totalCoeffs,
                'moyenne' => $totalCoeffs > 0 ? round($totalPoints / $totalCoeffs, 2) : 0,
            ];
        }

        $moyenneGenerale = $notes->avg('note');

        $pdf = Pdf::loadView('eleve.exports.bulletin-pdf', compact(
            'bulletin', 
            'eleve', 
            'notesParMatiere', 
            'moyenneGenerale'
        ));

        $filename = 'bulletin_' . $bulletin->periode . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Exporter l'emploi du temps au format PDF
     */
    public function exportEmploiDuTempsPdf()
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return redirect()->route('login')
                ->with('error', 'Aucun profil élève associé à ce compte.');
        }

        // MODIFICATION: Utiliser la méthode helper
        $classeActuelle = $this->getClasseActuelle($eleve);

        if (!$classeActuelle) {
            return redirect()->back()
                ->with('error', 'Vous n\'êtes pas inscrit dans une classe active.');
        }

        $emploiDuTemps = EmploiDuTemps::where('classe_id', $classeActuelle->id)
            ->with(['matiere', 'enseignant'])
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get();

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $emploiParJour = [];
        
        foreach ($jours as $jour) {
            $emploiParJour[$jour] = $emploiDuTemps->filter(function($cours) use ($jour) {
                return $cours->jour == $jour;
            })->values();
        }

        $pdf = Pdf::loadView('eleve.exports.emploi-temps-pdf', compact(
            'eleve', 
            'classeActuelle', 
            'emploiDuTemps', 
            'emploiParJour', 
            'jours'
        ));

        return $pdf->download('emploi_du_temps_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exporter le profil complet au format PDF
     */
    public function exportProfilPdf()
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return redirect()->route('login')
                ->with('error', 'Aucun profil élève associé à ce compte.');
        }

        // MODIFICATION: Charger les relations sans 'classe' directe
        $eleve->load([
            'inscriptions' => function($q) {
                $q->with(['classe.anneeScolaire'])->latest();
            },
            'parents',
            'notes' => function($q) {
                $q->with(['evaluation.matiere'])->latest()->take(50);
            },
            'absences' => function($q) {
                $q->with(['matiere'])->latest();
            },
            'bulletins' => function($q) {
                $q->with(['classe', 'anneeScolaire'])->latest();
            }
        ]);

        $classeActuelle = $this->getClasseActuelle($eleve);

        $stats = [
            'age' => $eleve->date_naissance->age,
            'moyenne_notes' => $eleve->notes->avg('note'),
            'total_absences' => $eleve->absences->count(),
            'absences_justifiees' => $eleve->absences->where('justifiee', true)->count(),
            'absences_non_justifiees' => $eleve->absences->where('justifiee', false)->count(),
            'total_inscriptions' => $eleve->inscriptions->count(),
            'total_parents' => $eleve->parents->count(),
            'total_bulletins' => $eleve->bulletins->count(),
            'classe_actuelle' => $classeActuelle ? $classeActuelle->nom . ' (' . $classeActuelle->niveau . ')' : 'Non assigné',
        ];

        $pdf = Pdf::loadView('eleve.exports.profil-pdf', compact('eleve', 'stats', 'classeActuelle'));

        return $pdf->download('profil_' . $eleve->nom . '_' . $eleve->prenom . '_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exporter le relevé de notes au format PDF
     */
    public function exportReleveNotesPdf(Request $request)
    {
        $eleve = $this->getEleveConnecte();

        if (!$eleve) {
            return redirect()->route('login')
                ->with('error', 'Aucun profil élève associé à ce compte.');
        }

        $periode = $request->get('periode', 'trimestre1');

        $notes = Note::where('eleve_id', $eleve->id)
            ->with(['evaluation.matiere', 'evaluation.classe'])
            ->whereHas('evaluation', function($q) use ($periode) {
                $q->where('periode', $periode);
            })
            ->get();

        $notesParMatiere = [];
        foreach ($notes as $note) {
            if ($note->evaluation && $note->evaluation->matiere) {
                $matiereId = $note->evaluation->matiere->id;
                if (!isset($notesParMatiere[$matiereId])) {
                    $notesParMatiere[$matiereId] = [
                        'matiere' => $note->evaluation->matiere,
                        'notes' => collect(),
                        'total' => 0,
                        'count' => 0
                    ];
                }
                $notesParMatiere[$matiereId]['notes']->push($note);
                $notesParMatiere[$matiereId]['total'] += $note->note;
                $notesParMatiere[$matiereId]['count']++;
            }
        }

        $moyennes = [];
        foreach ($notesParMatiere as $matiereId => $data) {
            $moyennes[$matiereId] = [
                'matiere' => $data['matiere'],
                'moyenne' => $data['count'] > 0 ? round($data['total'] / $data['count'], 2) : 0,
                'nombre_notes' => $data['count']
            ];
        }

        $moyenneGenerale = $notes->avg('note');

        $stats = [
            'periode' => $periode,
            'moyenne_generale' => $moyenneGenerale,
            'total_notes' => $notes->count(),
            'matieres' => count($moyennes),
        ];

        $classeActuelle = $this->getClasseActuelle($eleve);

        $pdf = Pdf::loadView('eleve.exports.releve-notes-pdf', compact('eleve', 'classeActuelle', 'notesParMatiere', 'moyennes', 'moyenneGenerale', 'periode', 'stats'));

        $filename = 'releve_notes_' . $eleve->nom . '_' . $eleve->prenom . '_' . $periode . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
