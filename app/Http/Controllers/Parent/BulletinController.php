<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Bulletin;
use App\Models\Note;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BulletinController extends Controller
{
    public function index(Request $request, Eleve $eleve)
    {
        $user = Auth::user();
        
        if (!$user->isParent()) {
            abort(403, 'Accès non autorisé.');
        }

        // Récupérer les bulletins de l'élève
        $query = Bulletin::where('eleve_id', $eleve->id)
            ->with(['classe', 'anneeScolaire']);

        // Appliquer les filtres
        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }
        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        }

        $bulletins = $query->orderBy('date_bulletin', 'desc')->paginate(12);

        // Récupérer les périodes distinctes pour les filtres
        $periodes = Bulletin::where('eleve_id', $eleve->id)
            ->distinct('periode')
            ->pluck('periode')
            ->filter()
            ->values();

        // Récupérer les années scolaires qui ont des bulletins
        $anneeScolaireIds = Bulletin::where('eleve_id', $eleve->id)
            ->whereNotNull('annee_scolaire_id')
            ->distinct('annee_scolaire_id')
            ->pluck('annee_scolaire_id');

        $anneesScolaires = AnneeScolaire::whereIn('id', $anneeScolaireIds)
            ->orderBy('date_debut', 'desc')
            ->get();

        // Statistiques
        $stats = [
            'total' => Bulletin::where('eleve_id', $eleve->id)->count(),
            'moyenne_globale' => round(Bulletin::where('eleve_id', $eleve->id)->avg('moyenne_generale') ?? 0, 2),
            'dernier' => Bulletin::where('eleve_id', $eleve->id)
                ->latest('date_bulletin')
                ->first(),
        ];

        return view('parent.bulletin-enfant', compact('eleve', 'bulletins', 'periodes', 'anneesScolaires', 'stats'));
    }

    public function show(Eleve $eleve, Bulletin $bulletin)
    {
        $user = Auth::user();
        
        if (!$user->isParent()) {
            abort(403, 'Accès non autorisé.');
        }

        if ($bulletin->eleve_id !== $eleve->id) {
            abort(404);
        }

        // Charger les relations de base
        $bulletin->load([
            'classe',
            'anneeScolaire',
        ]);

        Log::info('Tentative de récupération des notes pour le bulletin ID: ' . $bulletin->id);

        // MÉTHODE 1: Utiliser la relation notesBulletin du modèle (si elle existe)
        try {
            if (method_exists($bulletin, 'notesBulletin')) {
                $notes = $bulletin->notesBulletin()
                    ->with(['evaluation.matiere'])
                    ->get();
                Log::info('Méthode 1 - notes trouvées: ' . $notes->count());
            } else {
                $notes = collect([]);
            }
        } catch (\Exception $e) {
            Log::error('Erreur méthode 1: ' . $e->getMessage());
            $notes = collect([]);
        }

        // MÉTHODE 2: Requête manuelle sans la colonne appreciation (adaptée à votre structure)
        if ($notes->isEmpty()) {
            try {
                $notes = DB::table('bulletin_note')
                    ->join('notes', 'bulletin_note.note_id', '=', 'notes.id')
                    ->join('evaluations', 'notes.evaluation_id', '=', 'evaluations.id')
                    ->join('matieres', 'evaluations.matiere_id', '=', 'matieres.id')
                    ->where('bulletin_note.bulletin_id', $bulletin->id)
                    ->select(
                        'notes.*',
                        'evaluations.nom as evaluation_nom',
                        'evaluations.date_evaluation',
                        'evaluations.coefficient as evaluation_coefficient',
                        // 'evaluations.appreciation' RETIRÉ - n'existe pas
                        'matieres.id as matiere_id',
                        'matieres.nom as matiere_nom',
                        'bulletin_note.coefficient as pivot_coefficient',
                        'bulletin_note.appreciation as pivot_appreciation'
                    )
                    ->get();
                Log::info('Méthode 2 - notes trouvées: ' . $notes->count());
            } catch (\Exception $e) {
                Log::error('Erreur méthode 2: ' . $e->getMessage());
                $notes = collect([]);
            }
        }

        // MÉTHODE 3: Récupérer toutes les notes de l'élève pour cette période
        if ($notes->isEmpty()) {
            try {
                $notes = Note::where('eleve_id', $eleve->id)
                    ->whereHas('evaluation', function($q) use ($bulletin) {
                        $q->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
                          ->where('periode', $bulletin->periode);
                    })
                    ->with(['evaluation.matiere'])
                    ->get();
                Log::info('Méthode 3 - notes trouvées: ' . $notes->count());
            } catch (\Exception $e) {
                Log::error('Erreur méthode 3: ' . $e->getMessage());
                $notes = collect([]);
            }
        }

        // MÉTHODE 4: Récupérer toutes les notes de l'élève sans filtre
        if ($notes->isEmpty()) {
            try {
                $notes = Note::where('eleve_id', $eleve->id)
                    ->with(['evaluation.matiere'])
                    ->get();
                Log::info('Méthode 4 - notes trouvées: ' . $notes->count());
            } catch (\Exception $e) {
                Log::error('Erreur méthode 4: ' . $e->getMessage());
                $notes = collect([]);
            }
        }

        Log::info('Total notes trouvées: ' . $notes->count());

        // Organiser les notes par matière
        $notesParMatiere = [];
        $totalPoints = 0;
        $totalCoefficients = 0;
        
        foreach ($notes as $note) {
            // Déterminer la matière et le coefficient
            $matiereId = null;
            $matiereNom = 'Matière inconnue';
            $coefficient = 1;
            $evaluationNom = 'Évaluation';
            $dateEvaluation = null;
            $appreciation = '';
            
            // Cas 1: Note avec relations Eloquent chargées
            if (isset($note->evaluation) && $note->evaluation) {
                if (isset($note->evaluation->matiere)) {
                    $matiereId = $note->evaluation->matiere->id;
                    $matiereNom = $note->evaluation->matiere->nom;
                }
                $coefficient = $note->evaluation->coefficient ?? 1;
                $evaluationNom = $note->evaluation->nom ?? 'Évaluation';
                $dateEvaluation = $note->evaluation->date_evaluation ?? null;
                $appreciation = $note->appreciation ?? '';
            }
            // Cas 2: Note avec données de jointure (méthode 2)
            elseif (isset($note->matiere_id)) {
                $matiereId = $note->matiere_id;
                $matiereNom = $note->matiere_nom ?? 'Matière';
                $coefficient = $note->pivot_coefficient ?? $note->evaluation_coefficient ?? 1;
                $evaluationNom = $note->evaluation_nom ?? 'Évaluation';
                $dateEvaluation = $note->date_evaluation ?? null;
                $appreciation = $note->pivot_appreciation ?? $note->appreciation ?? '';
            }
            
            if (!$matiereId) {
                continue; // Ignorer si pas de matière
            }
            
            if (!isset($notesParMatiere[$matiereId])) {
                $notesParMatiere[$matiereId] = [
                    'matiere_nom' => $matiereNom,
                    'coefficient' => $coefficient,
                    'notes' => [],
                    'total_points' => 0,
                    'total_coefficients' => 0
                ];
            }
            
            // Ajouter la note (utiliser 'note' au lieu de 'valeur')
            $notesParMatiere[$matiereId]['notes'][] = [
                'valeur' => $note->note,  // Changé de 'note' à 'valeur' pour correspondre à la vue
                'evaluation' => $evaluationNom,
                'date' => $dateEvaluation,
                'coefficient' => $coefficient,
                'appreciation' => $appreciation
            ];
            
            $notesParMatiere[$matiereId]['total_points'] += $note->note * $coefficient;
            $notesParMatiere[$matiereId]['total_coefficients'] += $coefficient;
            
            $totalPoints += $note->note * $coefficient;
            $totalCoefficients += $coefficient;
        }
        
        // Calculer les moyennes par matière
        foreach ($notesParMatiere as &$matiereData) {
            if ($matiereData['total_coefficients'] > 0) {
                $matiereData['moyenne'] = round($matiereData['total_points'] / $matiereData['total_coefficients'], 2);
            } else {
                $matiereData['moyenne'] = 0;
            }
        }

        // Trier par nom de matière
        uasort($notesParMatiere, function($a, $b) {
            return strcmp($a['matiere_nom'], $b['matiere_nom']);
        });

        // Calculer la moyenne générale
        $moyenneGenerale = $bulletin->moyenne_generale ?? 
            ($totalCoefficients > 0 ? round($totalPoints / $totalCoefficients, 2) : 0);

        // Calculer la moyenne de la classe
        $moyenneClasse = Bulletin::where('classe_id', $bulletin->classe_id)
            ->where('periode', $bulletin->periode)
            ->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
            ->where('id', '!=', $bulletin->id)
            ->avg('moyenne_generale') ?? 0;

        // Mention
        $mention = $moyenneGenerale >= 16 ? 'Très bien' : 
                  ($moyenneGenerale >= 14 ? 'Bien' : 
                  ($moyenneGenerale >= 12 ? 'Assez bien' : 
                  ($moyenneGenerale >= 10 ? 'Passable' : 'Insuffisant')));
        
        $estAdmis = $moyenneGenerale >= 10;

        // Appréciations (si vous avez une table dédiée)
        $appreciations = collect([]);

        // Message de debug pour la vue
        if ($notes->isEmpty()) {
            session()->flash('debug_message', 'Aucune note trouvée pour ce bulletin. Vérifiez que des notes sont associées.');
        }

        return view('parent.bulletin-detail', compact(
            'eleve', 
            'bulletin', 
            'notesParMatiere', 
            'moyenneGenerale', 
            'moyenneClasse', 
            'totalPoints', 
            'totalCoefficients',
            'mention',
            'estAdmis',
            'appreciations'
        ));
    }

    public function telecharger(Eleve $eleve, Bulletin $bulletin)
    {
        $user = Auth::user();
        
        if (!$user->isParent()) {
            abort(403, 'Accès non autorisé.');
        }

        if ($bulletin->eleve_id !== $eleve->id) {
            abort(404);
        }

        return redirect()->back()->with('info', 'Téléchargement PDF bientôt disponible');
    }
}