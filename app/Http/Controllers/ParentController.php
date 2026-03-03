<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ParentEleve;
use App\Models\Eleve;
use App\Models\EleveParent;
use App\Models\Note;
use App\Models\Absence;
use App\Models\Bulletin;
use App\Models\Evaluation;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use App\Models\EmploiDuTemps;
use App\Models\Inscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ParentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function getParentConnecte()
    {
        $user = Auth::user();

        if (!$user) {
            return null;
        }

        return ParentEleve::where('user_id', $user->id)->first();
    }

    private function verifierEnfant($parent, $eleve): bool
    {
        if (!$parent) {
            abort(403, 'Parent non trouvé.');
        }

        $existe = EleveParent::where('parent_eleve_id', $parent->id)
                            ->where('eleve_id', $eleve->id)
                            ->exists();

        if (!$existe) {
            abort(403, 'Cet élève ne vous est pas associé.');
        }

        return true;
    }

    private function getEnfantsIds($parent): array
    {
        return EleveParent::where('parent_eleve_id', $parent->id)
                         ->pluck('eleve_id')
                         ->toArray();
    }

    private function getEnfantsAvecRelations($parent)
    {
        return EleveParent::with(['eleve' => function($query) {
                $query->with([
                    'inscriptions.classe',
                    'inscriptions.anneeScolaire',
                    'notes',
                    'absences',
                    'bulletins'
                ]);
            }])
            ->where('parent_eleve_id', $parent->id)
            ->get()
            ->pluck('eleve');
    }

    /**
     * Dashboard du parent
     */
    public function dashboard()
    {
        $parent = $this->getParentConnecte();

        if (!$parent) {
            return redirect('/')
                ->with('error', 'Aucun profil parent associé à votre compte.');
        }

        $enfants = $this->getEnfantsAvecRelations($parent);
        $relations = EleveParent::with('eleve')
                                ->where('parent_eleve_id', $parent->id)
                                ->get();

        $stats = $this->calculerStatsDashboard($enfants);
        $donneesEnfants = $this->getDonneesEnfants($enfants);

        foreach ($enfants as $enfant) {
            $relation = $relations->firstWhere('eleve_id', $enfant->id);
            $enfant->lien_parental = $relation ? $relation->lien_parental_libelle : 'Parent';
        }

        return view('parent.dashboard', compact('parent', 'enfants', 'donneesEnfants', 'stats'));
    }

    private function calculerStatsDashboard($enfants): array
    {
        $enfantsIds = $enfants->pluck('id')->toArray();

        return [
            'total_enfants' => count($enfantsIds),
            'total_notes' => Note::whereIn('eleve_id', $enfantsIds)->count(),
            'total_absences' => Absence::whereIn('eleve_id', $enfantsIds)->count(),
            'absences_non_justifiees' => Absence::whereIn('eleve_id', $enfantsIds)
                ->where('justifiee', false)
                ->count(),
            'total_bulletins' => Bulletin::whereIn('eleve_id', $enfantsIds)->count(),
        ];
    }

    private function getDonneesEnfants($enfants): array
    {
        $donnees = [];

        foreach ($enfants as $enfant) {
            $donnees[$enfant->id] = [
                'dernieres_notes' => Note::where('eleve_id', $enfant->id)
                    ->with(['evaluation.matiere'])
                    ->latest()
                    ->limit(5)
                    ->get(),
                'dernieres_absences' => Absence::where('eleve_id', $enfant->id)
                    ->with(['matiere'])
                    ->latest('date_absence')
                    ->limit(5)
                    ->get(),
                'dernier_bulletin' => Bulletin::where('eleve_id', $enfant->id)
                    ->with(['anneeScolaire'])
                    ->latest()
                    ->first(),
                'moyenne_generale' => $this->calculerMoyenneEleve($enfant->id),
            ];
        }

        return $donnees;
    }

    /**
     * Liste des enfants
     */
    public function mesEnfants()
    {
        $parent = $this->getParentConnecte();

        if (!$parent) {
            return redirect('/')
                ->with('error', 'Aucun parent associé à ce compte.');
        }

        $relations = EleveParent::with(['eleve' => function($query) {
                $query->with([
                    'inscriptions' => function($q) {
                        $q->with(['anneeScolaire', 'classe'])->latest();
                    }
                ]);
            }])
            ->where('parent_eleve_id', $parent->id)
            ->get();

        $enfants = collect();

        foreach ($relations as $relation) {
            $eleve = $relation->eleve;
            if ($eleve) {
                $eleve->lien_parental = $relation->lien_parental_libelle;
                $eleve->relation_id = $relation->id;
                $eleve->derniere_inscription = $eleve->inscriptions->first();
                $eleve->stats = $this->calculerStatsEnfant($eleve->id);
                $enfants->push($eleve);
            }
        }

        $statsGlobales = [
            'total' => $enfants->count(),
            'total_notes' => Note::whereIn('eleve_id', $enfants->pluck('id'))->count(),
            'total_absences' => Absence::whereIn('eleve_id', $enfants->pluck('id'))->count(),
            'total_bulletins' => Bulletin::whereIn('eleve_id', $enfants->pluck('id'))->count(),
        ];

        return view('parent.enfants', compact('enfants', 'parent', 'statsGlobales'));
    }

    private function calculerStatsEnfant($eleveId): array
    {
        return [
            'notes_count' => Note::where('eleve_id', $eleveId)->count(),
            'absences_count' => Absence::where('eleve_id', $eleveId)->count(),
            'absences_non_justifiees' => Absence::where('eleve_id', $eleveId)
                ->where('justifiee', false)
                ->count(),
            'bulletins_count' => Bulletin::where('eleve_id', $eleveId)->count(),
            'moyenne_generale' => $this->calculerMoyenneEleve($eleveId),
        ];
    }

    private function calculerMoyenneEleve($eleveId): float
    {
        $notes = Note::where('eleve_id', $eleveId)
            ->whereHas('evaluation', function($query) {
                $query->whereNotNull('matiere_id');
            })
            ->with('evaluation.matiere')
            ->get();

        if ($notes->isEmpty()) {
            return 0;
        }

        $totalPoints = 0;
        $totalCoefficients = 0;

        foreach ($notes as $note) {
            $coefficient = $note->evaluation->matiere->coefficient ?? 1;
            $totalPoints += $note->note * $coefficient;
            $totalCoefficients += $coefficient;
        }

        return $totalCoefficients > 0 ? round($totalPoints / $totalCoefficients, 2) : 0;
    }

    /**
     * Notes d'un enfant
     */
    public function notesEnfant(Request $request, Eleve $eleve)
    {
        $parent = $this->verifierAccesParent($eleve);

        $relation = EleveParent::where('parent_eleve_id', $parent->id)
                               ->where('eleve_id', $eleve->id)
                               ->first();

        $lienParental = $relation ? $relation->lien_parental_libelle : 'Parent';

        $inscription = $this->getInscriptionActuelle($eleve);

        if (!$inscription) {
            return view('parent.notes-enfant', [
                'eleve' => $eleve,
                'lienParental' => $lienParental,
                'message' => 'Cet élève n\'est pas inscrit pour l\'année en cours.'
            ]);
        }

        $notes = $this->getNotesFiltrees($request, $eleve, $inscription);
        $stats = $this->calculerStatsNotes($eleve, $inscription);
        $matieres = $this->getMatieresClasse($inscription->classe_id);
        $periodes = ['Trimestre 1', 'Trimestre 2', 'Trimestre 3'];

        return view('parent.notes-enfant', compact(
            'notes',
            'eleve',
            'lienParental',
            'inscription',
            'stats',
            'matieres',
            'periodes'
        ));
    }

    private function verifierAccesParent(Eleve $eleve)
    {
        $parent = $this->getParentConnecte();

        if (!$parent) {
            abort(403, 'Aucun parent associé à ce compte.');
        }

        $this->verifierEnfant($parent, $eleve);

        return $parent;
    }

    private function getInscriptionActuelle(Eleve $eleve)
    {
        return Inscription::where('eleve_id', $eleve->id)
            ->with(['classe', 'anneeScolaire'])
            ->latest()
            ->first();
    }

    private function getNotesFiltrees(Request $request, Eleve $eleve, $inscription)
    {
        $query = Note::where('eleve_id', $eleve->id)
            ->whereHas('evaluation', function($q) use ($inscription) {
                $q->where('classe_id', $inscription->classe_id);
            })
            ->with(['evaluation.matiere', 'evaluation']);

        $this->appliquerFiltresNotes($request, $query);

        return $query->orderByDesc(
                Evaluation::select('date_evaluation')
                    ->whereColumn('evaluations.id', 'notes.evaluation_id')
            )
            ->orderByDesc('notes.created_at')
            ->paginate(20)
            ->withQueryString();
    }

    private function appliquerFiltresNotes(Request $request, $query): void
    {
        if ($request->filled('matiere_id')) {
            $query->whereHas('evaluation', fn($q) => $q->where('matiere_id', $request->matiere_id));
        }

        if ($request->filled('periode')) {
            $query->whereHas('evaluation', fn($q) => $q->where('periode', $request->periode));
        }

        if ($request->filled('date_debut')) {
            $query->whereHas('evaluation', fn($q) => $q->whereDate('date_evaluation', '>=', $request->date_debut));
        }

        if ($request->filled('date_fin')) {
            $query->whereHas('evaluation', fn($q) => $q->whereDate('date_evaluation', '<=', $request->date_fin));
        }
    }

    private function calculerStatsNotes(Eleve $eleve, $inscription): array
    {
        return [
            'total_notes' => Note::where('eleve_id', $eleve->id)->count(),
            'moyenne_generale' => $this->calculerMoyenneEleve($eleve->id),
            'moyenne_trimestre' => $this->calculerMoyenneTrimestre($eleve->id, $inscription->classe_id),
            'note_min' => Note::where('eleve_id', $eleve->id)->min('note') ?? 0,
            'note_max' => Note::where('eleve_id', $eleve->id)->max('note') ?? 0,
        ];
    }

    private function getMatieresClasse($classeId)
    {
        return Matiere::whereHas('classeMatieres', function($q) use ($classeId) {
                $q->where('classe_id', $classeId);
            })
            ->orderBy('nom')
            ->get();
    }

    private function calculerMoyenneTrimestre($eleveId, $classeId): float
    {
        $trimestreActuel = $this->getTrimestreActuel();

        $notes = Note::where('eleve_id', $eleveId)
            ->whereHas('evaluation', function($query) use ($classeId, $trimestreActuel) {
                $query->where('classe_id', $classeId)
                      ->where('periode', $trimestreActuel);
            })
            ->with('evaluation.matiere')
            ->get();

        if ($notes->isEmpty()) {
            return 0;
        }

        $totalPoints = 0;
        $totalCoefficients = 0;

        foreach ($notes as $note) {
            $coefficient = $note->evaluation->matiere->coefficient ?? 1;
            $totalPoints += $note->note * $coefficient;
            $totalCoefficients += $coefficient;
        }

        return $totalCoefficients > 0 ? round($totalPoints / $totalCoefficients, 2) : 0;
    }

    private function getTrimestreActuel(): string
    {
        $mois = now()->month;

        if ($mois >= 9 && $mois <= 12) {
            return 'Trimestre 1';
        } elseif ($mois >= 1 && $mois <= 3) {
            return 'Trimestre 2';
        } else {
            return 'Trimestre 3';
        }
    }

    /**
     * Absences d'un enfant
     */
    public function absencesEnfant(Request $request, Eleve $eleve)
    {
        $parent = $this->verifierAccesParent($eleve);

        $relation = EleveParent::where('parent_eleve_id', $parent->id)
                               ->where('eleve_id', $eleve->id)
                               ->first();

        $lienParental = $relation ? $relation->lien_parental_libelle : 'Parent';

        $absences = $this->getAbsencesFiltrees($request, $eleve);
        $stats = $this->calculerStatsAbsences($eleve);
        $matieres = Matiere::orderBy('nom')->get();
        $mois = $this->getMoisFrancais();

        return view('parent.absences-enfant', compact(
            'absences',
            'eleve',
            'lienParental',
            'stats',
            'matieres',
            'mois'
        ));
    }

    private function getAbsencesFiltrees(Request $request, Eleve $eleve)
    {
        $query = Absence::where('eleve_id', $eleve->id)
            ->with(['matiere']);

        if ($request->filled('justifiee')) {
            $query->where('justifiee', $request->justifiee === 'oui');
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

        if ($request->filled('mois')) {
            $query->whereMonth('date_absence', $request->mois);
        }

        if ($request->filled('annee')) {
            $query->whereYear('date_absence', $request->annee);
        }

        return $query->orderBy('date_absence', 'desc')
            ->paginate(20)
            ->withQueryString();
    }

    private function calculerStatsAbsences(Eleve $eleve): array
    {
        return [
            'total' => Absence::where('eleve_id', $eleve->id)->count(),
            'justifiees' => Absence::where('eleve_id', $eleve->id)->where('justifiee', true)->count(),
            'non_justifiees' => Absence::where('eleve_id', $eleve->id)->where('justifiee', false)->count(),
            'mois_courant' => Absence::where('eleve_id', $eleve->id)
                ->whereMonth('date_absence', now()->month)
                ->whereYear('date_absence', now()->year)
                ->count(),
            'annee_courante' => Absence::where('eleve_id', $eleve->id)
                ->whereYear('date_absence', now()->year)
                ->count(),
        ];
    }

    private function getMoisFrancais(): array
    {
        return [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];
    }

    /**
     * Liste des bulletins
     */
    public function bulletinsEnfant(Request $request, Eleve $eleve)
    {
        $parent = $this->verifierAccesParent($eleve);

        $relation = EleveParent::where('parent_eleve_id', $parent->id)
                               ->where('eleve_id', $eleve->id)
                               ->first();

        $lienParental = $relation ? $relation->lien_parental_libelle : 'Parent';

        $bulletins = $this->getBulletinsFiltres($request, $eleve);
        $stats = $this->calculerStatsBulletins($eleve->id);
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $periodes = ['Trimestre 1', 'Trimestre 2', 'Trimestre 3', 'Semestre 1', 'Semestre 2', 'Annuel'];

        return view('parent.bulletin-enfant', compact(
            'bulletins',
            'eleve',
            'lienParental',
            'stats',
            'anneesScolaires',
            'periodes'
        ));
    }

    private function getBulletinsFiltres(Request $request, Eleve $eleve)
    {
        $query = Bulletin::where('eleve_id', $eleve->id)
            ->with([
                'classe',
                'anneeScolaire',
                'notesBulletin' => function($q) {
                    $q->with(['evaluation.matiere']);
                }
            ]);

        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }

        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        }

        return $query->orderBy('annee_scolaire_id', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(9)
            ->withQueryString();
    }

    private function calculerStatsBulletins($eleveId): array
    {
        return [
            'total' => Bulletin::where('eleve_id', $eleveId)->count(),
            'dernier' => Bulletin::where('eleve_id', $eleveId)->latest()->first(),
            'moyenne_globale' => $this->calculerMoyenneGlobaleBulletins($eleveId),
        ];
    }

    private function calculerMoyenneGlobaleBulletins($eleveId): float
    {
        $bulletins = Bulletin::where('eleve_id', $eleveId)->get();

        if ($bulletins->isEmpty()) {
            return 0;
        }

        $total = 0;
        foreach ($bulletins as $bulletin) {
            $total += $bulletin->moyenne_generale ?? 0;
        }

        return round($total / $bulletins->count(), 2);
    }

    /**
     * Détail d'un bulletin
     */
    public function detailBulletinEnfant(Eleve $eleve, Bulletin $bulletin)
    {
        $parent = $this->verifierAccesParent($eleve);

        if ($bulletin->eleve_id != $eleve->id) {
            abort(404, 'Bulletin non trouvé.');
        }

        $relation = EleveParent::where('parent_eleve_id', $parent->id)
                               ->where('eleve_id', $eleve->id)
                               ->first();

        $lienParental = $relation ? $relation->lien_parental_libelle : 'Parent';

        $bulletin->load([
            'classe',
            'anneeScolaire',
            'notesBulletin' => function($q) {
                $q->with(['evaluation.matiere'])
                  ->orderBy('evaluation_id');
            }
        ]);

        $notesParMatiere = $this->organiserNotesParMatiere($bulletin);
        $moyenneGenerale = $this->calculerMoyenneBulletin($bulletin, $notesParMatiere);

        // Calculer la moyenne de la classe
        $moyenneClasse = $this->calculerMoyenneClasse($bulletin);

        // Calculer le total des points
        $totalPoints = $notesParMatiere['total']['points'] ?? 0;

        $appreciations = $this->getAppreciations($moyenneGenerale);

        return view('parent.bulletin-detail', compact(
            'eleve',
            'bulletin',
            'lienParental',
            'notesParMatiere',
            'moyenneGenerale',
            'moyenneClasse',
            'totalPoints',
            'appreciations'
        ));
    }

    /**
     * Calculer la moyenne de la classe pour le bulletin
     */
    private function calculerMoyenneClasse(Bulletin $bulletin): float
    {
        // Récupérer tous les bulletins de la même classe, période et année scolaire
        $bulletinsClasse = Bulletin::where('classe_id', $bulletin->classe_id)
            ->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
            ->where('periode', $bulletin->periode)
            ->whereNotNull('moyenne_generale')
            ->get();

        if ($bulletinsClasse->isEmpty()) {
            return 0;
        }

        $total = $bulletinsClasse->sum('moyenne_generale');
        return round($total / $bulletinsClasse->count(), 2);
    }

    /**
     * Télécharger le bulletin
     */
    public function telechargerBulletin(Eleve $eleve, Bulletin $bulletin)
    {
        $parent = $this->verifierAccesParent($eleve);

        if ($bulletin->eleve_id != $eleve->id) {
            abort(404, 'Bulletin non trouvé.');
        }

        $relation = EleveParent::where('parent_eleve_id', $parent->id)
                               ->where('eleve_id', $eleve->id)
                               ->first();

        $lienParental = $relation ? $relation->lien_parental_libelle : 'Parent';

        $bulletin->load([
            'classe',
            'anneeScolaire',
            'notesBulletin' => function($q) {
                $q->with(['evaluation.matiere'])
                  ->orderBy('evaluation_id');
            }
        ]);

        $notesParMatiere = $this->organiserNotesParMatiere($bulletin);
        $moyenneGenerale = $this->calculerMoyenneBulletin($bulletin, $notesParMatiere);
        $moyenneClasse = $this->calculerMoyenneClasse($bulletin);
        $totalPoints = $notesParMatiere['total']['points'] ?? 0;
        $appreciations = $this->getAppreciations($moyenneGenerale);

        return view('parent.bulletin-detail', compact(
            'eleve',
            'bulletin',
            'lienParental',
            'notesParMatiere',
            'moyenneGenerale',
            'moyenneClasse',
            'totalPoints',
            'appreciations'
        ));
    }

    private function organiserNotesParMatiere($bulletin): array
    {
        $notesParMatiere = [];
        $totalPoints = 0;
        $totalCoeffs = 0;

        foreach ($bulletin->notesBulletin as $note) {
            if ($note->evaluation && $note->evaluation->matiere) {
                $matiereId = $note->evaluation->matiere->id;
                $coefficient = $note->pivot->coefficient ?? $note->evaluation->coefficient ?? 1;

                if (!isset($notesParMatiere[$matiereId])) {
                    $notesParMatiere[$matiereId] = $this->initialiserMatiere($note);
                }

                $this->ajouterNoteAMatiere($notesParMatiere[$matiereId], $note, $coefficient);

                $totalPoints += $note->note * $coefficient;
                $totalCoeffs += $coefficient;
            }
        }

        $this->calculerMoyennesMatieres($notesParMatiere);
        $notesParMatiere['total'] = ['points' => $totalPoints, 'coefficients' => $totalCoeffs];

        return $notesParMatiere;
    }

    private function initialiserMatiere($note): array
    {
        return [
            'matiere_id' => $note->evaluation->matiere->id,
            'matiere_nom' => $note->evaluation->matiere->nom,
            'matiere_code' => $note->evaluation->matiere->code,
            'notes' => [],
            'total' => 0,
            'count' => 0,
            'coefficient' => $note->pivot->coefficient ?? $note->evaluation->coefficient ?? 1,
            'total_pondere' => 0
        ];
    }

    private function ajouterNoteAMatiere(&$matiere, $note, $coefficient): void
    {
        $matiere['notes'][] = [
            'id' => $note->id,
            'valeur' => $note->note,
            'evaluation' => $note->evaluation->titre ?? 'Évaluation',
            'date' => $note->evaluation->date_evaluation ?? null,
            'coefficient' => $coefficient,
            'appreciation' => $note->appreciation ?? null,
        ];

        $matiere['total'] += $note->note;
        $matiere['total_pondere'] += $note->note * $coefficient;
        $matiere['count']++;
    }

    private function calculerMoyennesMatieres(&$notesParMatiere): void
    {
        foreach ($notesParMatiere as &$data) {
            if ($data['count'] > 0) {
                $data['moyenne_simple'] = round($data['total'] / $data['count'], 2);
                $data['moyenne_ponderee'] = round($data['total_pondere'] / $data['count'], 2);
                $data['moyenne'] = $data['moyenne_ponderee'];
            }
        }
    }

    private function calculerMoyenneBulletin($bulletin, $notesParMatiere): float
    {
        $totalPoints = $notesParMatiere['total']['points'] ?? 0;
        $totalCoeffs = $notesParMatiere['total']['coefficients'] ?? 0;

        return $totalCoeffs > 0 ? round($totalPoints / $totalCoeffs, 2) : 0;
    }

    private function getAppreciations($moyenneGenerale): array
    {
        return [
            'excellente' => $moyenneGenerale >= 16,
            'tres_bien' => $moyenneGenerale >= 14 && $moyenneGenerale < 16,
            'bien' => $moyenneGenerale >= 12 && $moyenneGenerale < 14,
            'assez_bien' => $moyenneGenerale >= 10 && $moyenneGenerale < 12,
            'insuffisant' => $moyenneGenerale < 10,
        ];
    }

    /**
     * Emploi du temps
     */
    public function emploiDuTempsEnfant(Request $request, Eleve $eleve)
    {
        $parent = $this->verifierAccesParent($eleve);

        $relation = EleveParent::where('parent_eleve_id', $parent->id)
                               ->where('eleve_id', $eleve->id)
                               ->first();

        $lienParental = $relation ? $relation->lien_parental_libelle : 'Parent';

        $inscription = $this->getInscriptionActuelle($eleve);

        if (!$inscription || !$inscription->classe) {
            return view('parent.emploi-du-temps-enfant', [
                'eleve' => $eleve,
                'lienParental' => $lienParental,
                'emploiParJour' => [],
                'classe' => null,
                'message' => 'Cet élève n\'est pas inscrit dans une classe pour cette année.'
            ]);
        }

        $classe = $inscription->classe;
        $emploiDuTemps = $this->getEmploiDuTemps($request, $classe, $inscription);

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $emploiParJour = $this->organiserEmploiParJour($emploiDuTemps, $jours);
        $creneaux = $this->getCreneauxHoraires($emploiDuTemps);

        return view('parent.emploi-du-temps-enfant', compact(
            'emploiDuTemps',
            'emploiParJour',
            'eleve',
            'lienParental',
            'classe',
            'inscription',
            'jours',
            'creneaux'
        ));
    }

    private function getEmploiDuTemps(Request $request, $classe, $inscription)
    {
        $query = EmploiDuTemps::where('classe_id', $classe->id)
            ->where(function($q) use ($inscription) {
                $q->where('annee_scolaire_id', $inscription->annee_scolaire_id)
                  ->orWhereNull('annee_scolaire_id');
            })
            ->with(['matiere', 'enseignant']);

        if ($request->filled('jour')) {
            $query->where('jour', $request->jour);
        }

        if ($request->filled('semaine')) {
            $query->where('semaine', $request->semaine);
        }

        return $query->orderByRaw("FIELD(jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi')")
            ->orderBy('heure_debut')
            ->get();
    }

    private function organiserEmploiParJour($emploiDuTemps, $jours): array
    {
        $emploiParJour = [];
        foreach ($jours as $jour) {
            $emploiParJour[$jour] = $emploiDuTemps->filter(function($cours) use ($jour) {
                return $cours->jour == $jour;
            })->values();
        }
        return $emploiParJour;
    }

    private function getCreneauxHoraires($emploiDuTemps): array
    {
        $creneaux = [];

        if ($emploiDuTemps->isNotEmpty()) {
            $heures = $emploiDuTemps->pluck('heure_debut')
                ->merge($emploiDuTemps->pluck('heure_fin'))
                ->unique()
                ->sort()
                ->values();

            foreach ($heures as $index => $heure) {
                if ($index < $heures->count() - 1) {
                    $creneaux[] = [
                        'debut' => $heure,
                        'fin' => $heures[$index + 1],
                        'label' => substr($heure, 0, 5) . ' - ' . substr($heures[$index + 1], 0, 5)
                    ];
                }
            }
        }

        return $creneaux;
    }

    /**
     * Justifier une absence
     */
    public function justifierAbsence(Request $request, Absence $absence)
    {
        $parent = $this->getParentConnecte();

        if (!$parent) {
            return redirect('/')
                ->with('error', 'Aucun parent associé à ce compte.');
        }

        $existe = EleveParent::where('parent_eleve_id', $parent->id)
                            ->where('eleve_id', $absence->eleve_id)
                            ->exists();

        if (!$existe) {
            abort(403, 'Cette absence ne concerne pas un de vos enfants.');
        }

        $request->validate([
            'motif' => 'required|string|max:500',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $absence->justifiee = true;
        $absence->motif_justification = $request->motif;

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('absences/justificatifs', 'public');
            $absence->justificatif_path = $path;
        }

        $absence->save();

        return redirect()->back()->with('success', 'Absence justifiée avec succès.');
    }
}
