<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Enseignant;
use App\Models\Absence;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\EnseignantMatiereClasse;
use Carbon\Carbon;

class AbsenceController extends Controller
{
    protected $enseignant;

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
     * Affiche la liste des absences
     */
    public function index(Request $request)
    {
        // Récupérer les IDs des classes enseignées par l'enseignant
        $classeIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->distinct('classe_id')
            ->pluck('classe_id');

        // Récupérer les IDs des élèves dans ces classes
        $eleveIds = Inscription::whereIn('classe_id', $classeIds)
            ->where('statut', 'actif')
            ->pluck('eleve_id');

        // Requête de base pour les absences
        $query = Absence::with(['eleve', 'eleve.classe', 'matiere'])
            ->whereIn('eleve_id', $eleveIds);

        // Filtres
        if ($request->filled('date_debut')) {
            $query->whereDate('date_absence', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('date_absence', '<=', $request->date_fin);
        }

        if ($request->filled('classe_id')) {
            $elevesDeClasse = Inscription::where('classe_id', $request->classe_id)
                ->where('statut', 'actif')
                ->pluck('eleve_id');
            $query->whereIn('eleve_id', $elevesDeClasse);
        }

        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        if ($request->filled('statut')) {
            if ($request->statut === 'justifie') {
                $query->where('justifiee', true); // ← CORRIGÉ: 'justifiee' au lieu de 'justifie'
            } elseif ($request->statut === 'non_justifie') {
                $query->where('justifiee', false); // ← CORRIGÉ: 'justifiee' au lieu de 'justifie'
            }
        }

        // Tri
        $query->orderBy('date_absence', 'desc')
              ->orderBy('heure_debut', 'desc');

        // Pagination
        $absences = $query->paginate(15)->withQueryString();

        // Données pour les filtres
        $classes = Classe::whereIn('id', $classeIds)->get();
        $matieres = Matiere::whereHas('enseignantMatiereClasses', function($q) {
            $q->where('enseignant_id', $this->enseignant->id);
        })->get();

        // Statistiques
        $statistiques = $this->getStatistiques($eleveIds);

        return view('enseignant.absences', compact(
            'absences', 
            'classes', 
            'matieres', 
            'statistiques'
        ));
    }

    /**
     * Affiche le formulaire de création d'absence
     */
    public function create()
    {
        // Récupérer les classes de l'enseignant
        $classes = Classe::whereHas('enseignantMatiereClasses', function($q) {
            $q->where('enseignant_id', $this->enseignant->id);
        })->with(['eleves' => function($q) {
            $q->wherePivot('statut', 'actif');
        }])->get();

        // Récupérer les matières de l'enseignant
        $matieres = Matiere::whereHas('enseignantMatiereClasses', function($q) {
            $q->where('enseignant_id', $this->enseignant->id);
        })->get();

        return view('enseignant.absences-create', compact('classes', 'matieres'));
    }

    /**
     * Enregistre une nouvelle absence
     */
    public function store(Request $request)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'date_absence' => 'required|date|after_or_equal:today',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'motif' => 'nullable|string|max:255',
            'justifie' => 'sometimes|boolean'
        ], [
            'date_absence.after_or_equal' => 'La date d\'absence ne peut pas être dans le passé.',
            'heure_fin.after' => 'L\'heure de fin doit être après l\'heure de début.'
        ]);

        // Vérifier si l'élève est dans une classe de l'enseignant
        $classeIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->pluck('classe_id');

        $eleveDansClasse = Inscription::where('eleve_id', $request->eleve_id)
            ->whereIn('classe_id', $classeIds)
            ->where('statut', 'actif')
            ->exists();

        if (!$eleveDansClasse) {
            return back()->withErrors(['eleve_id' => "Cet élève n'est pas dans une classe que vous enseignez."])->withInput();
        }

        // Vérifier si une absence existe déjà pour cette période
        $existe = Absence::where('eleve_id', $request->eleve_id)
            ->where('date_absence', $request->date_absence)
            ->where(function($q) use ($request) {
                $q->where(function($q) use ($request) {
                    $q->where('heure_debut', '<=', $request->heure_debut)
                      ->where('heure_fin', '>=', $request->heure_debut);
                })->orWhere(function($q) use ($request) {
                    $q->where('heure_debut', '<=', $request->heure_fin)
                      ->where('heure_fin', '>=', $request->heure_fin);
                });
            })
            ->exists();

        if ($existe) {
            return back()->withErrors(['error' => 'Une absence existe déjà pour cette période.'])->withInput();
        }

        // Créer l'absence (SANS nombre_heures)
        try {
            Absence::create([
                'eleve_id' => $request->eleve_id,
                'matiere_id' => $request->matiere_id,
                'date_absence' => $request->date_absence,
                'heure_debut' => $request->heure_debut,
                'heure_fin' => $request->heure_fin,
                'motif' => $request->motif,
                'justifiee' => $request->has('justifie'), // ← CORRIGÉ: 'justifiee' au lieu de 'justifie'
                'annee_scolaire_id' => 1, // À adapter selon votre logique
            ]);

            return redirect()->route('enseignant.absences.index')
                ->with('success', 'Absence enregistrée avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'enregistrement.'])->withInput();
        }
    }

    /**
     * Affiche les détails d'une absence
     */
    public function show($id)
    {
        $absence = Absence::with(['eleve', 'eleve.classe', 'matiere'])
            ->findOrFail($id);

        // Vérifier que l'élève est dans une classe de l'enseignant
        $classeIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->pluck('classe_id');

        $eleveDansClasse = Inscription::where('eleve_id', $absence->eleve_id)
            ->whereIn('classe_id', $classeIds)
            ->exists();

        if (!$eleveDansClasse) {
            return redirect()->route('enseignant.absences.index')
                ->with('error', 'Vous n\'avez pas accès à cette absence.');
        }

        return view('enseignant.absences-show', compact('absence'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id)
    {
        $absence = Absence::findOrFail($id);

        // Vérifier que l'élève est dans une classe de l'enseignant
        $classeIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->pluck('classe_id');

        $eleveDansClasse = Inscription::where('eleve_id', $absence->eleve_id)
            ->whereIn('classe_id', $classeIds)
            ->exists();

        if (!$eleveDansClasse) {
            return redirect()->route('enseignant.absences.index')
                ->with('error', 'Vous n\'avez pas accès à cette absence.');
        }

        $classes = Classe::whereHas('enseignantMatiereClasses', function($q) {
            $q->where('enseignant_id', $this->enseignant->id);
        })->with(['eleves' => function($q) {
            $q->wherePivot('statut', 'actif');
        }])->get();

        $matieres = Matiere::whereHas('enseignantMatiereClasses', function($q) {
            $q->where('enseignant_id', $this->enseignant->id);
        })->get();

        return view('enseignant.absences-edit', compact('absence', 'classes', 'matieres'));
    }

    /**
     * Met à jour une absence
     */
    public function update(Request $request, $id)
    {
        $absence = Absence::findOrFail($id);

        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'date_absence' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'motif' => 'nullable|string|max:255',
            'justifie' => 'sometimes|boolean'
        ]);

        $absence->update([
            'eleve_id' => $request->eleve_id,
            'matiere_id' => $request->matiere_id,
            'date_absence' => $request->date_absence,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
            'motif' => $request->motif,
            'justifiee' => $request->has('justifie'), // ← CORRIGÉ: 'justifiee' au lieu de 'justifie'
        ]);

        return redirect()->route('enseignant.absences.index')
            ->with('success', 'Absence mise à jour avec succès.');
    }

    /**
     * Supprime une absence
     */
    public function destroy($id)
    {
        try {
            $absence = Absence::findOrFail($id);
            
            // Vérifier que l'élève est dans une classe de l'enseignant
            $classeIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
                ->pluck('classe_id');

            $eleveDansClasse = Inscription::where('eleve_id', $absence->eleve_id)
                ->whereIn('classe_id', $classeIds)
                ->exists();

            if (!$eleveDansClasse) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'avez pas accès à cette absence.'
                ], 403);
            }

            $absence->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Absence supprimée avec succès.'
                ]);
            }

            return redirect()->route('enseignant.absences.index')
                ->with('success', 'Absence supprimée avec succès.');
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
     * Justifie une absence
     */
    public function justify(Request $request, $id)
    {
        $request->validate([
            'motif' => 'required|string|max:255'
        ]);

        try {
            $absence = Absence::findOrFail($id);
            
            $absence->update([
                'justifiee' => true, // ← CORRIGÉ: 'justifiee' au lieu de 'justifie'
                'motif' => $request->motif
            ]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Absence justifiée avec succès.'
                ]);
            }

            return redirect()->back()->with('success', 'Absence justifiée avec succès.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la justification.'
                ], 500);
            }

            return back()->with('error', 'Erreur lors de la justification.');
        }
    }

    /**
     * Marque une présence (supprime l'absence)
     */
    public function marquerPresence(Request $request, $eleveId)
    {
        $request->validate([
            'date_absence' => 'required|date',
            'heure_debut' => 'required',
        ]);

        $absence = Absence::where('eleve_id', $eleveId)
            ->where('date_absence', $request->date_absence)
            ->where('heure_debut', $request->heure_debut)
            ->first();

        if ($absence) {
            $absence->delete();
            return response()->json(['success' => true, 'message' => 'Présence marquée avec succès.']);
        }

        return response()->json(['success' => false, 'message' => 'Absence non trouvée.'], 404);
    }

    /**
     * Récupère les élèves d'une classe pour le formulaire (API)
     */
    public function getElevesByClasse($classeId)
    {
        try {
            $eleves = Eleve::whereHas('inscriptions', function($q) use ($classeId) {
                $q->where('classe_id', $classeId)
                  ->where('statut', 'actif');
            })->select('id', 'nom', 'prenom', 'matricule')->get();

            return response()->json([
                'success' => true,
                'data' => $eleves
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des élèves.'
            ], 500);
        }
    }

    /**
     * Calcule les statistiques globales (SANS nombre_heures)
     */
    private function getStatistiques($eleveIds)
    {
        $totalAbsences = Absence::whereIn('eleve_id', $eleveIds)->count();
        
        // Comme il n'y a pas de colonne nombre_heures, on utilise le nombre d'absences
        $totalHeures = $totalAbsences; // Ou 1 heure par absence par défaut
        
        $nonJustifiees = Absence::whereIn('eleve_id', $eleveIds)->where('justifiee', false)->count(); // ← CORRIGÉ: 'justifiee'
        $justifiees = $totalAbsences - $nonJustifiees;

        return [
            'total_absences' => $totalAbsences,
            'total_heures' => $totalHeures,
            'non_justifiees' => $nonJustifiees,
            'justifiees' => $justifiees,
            'taux_justification' => $totalAbsences > 0 
                ? round(($justifiees / $totalAbsences) * 100, 2) 
                : 0
        ];
    }

    /**
     * Affiche les statistiques des absences
     */
    public function statistiques(Request $request)
    {
        $classeIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->distinct('classe_id')
            ->pluck('classe_id');

        $eleveIds = Inscription::whereIn('classe_id', $classeIds)
            ->where('statut', 'actif')
            ->pluck('eleve_id');

        // Statistiques par classe
        $statsParClasse = [];
        foreach ($classeIds as $classeId) {
            $classe = Classe::find($classeId);
            $elevesDeClasse = Inscription::where('classe_id', $classeId)
                ->where('statut', 'actif')
                ->pluck('eleve_id');

            $totalAbsences = Absence::whereIn('eleve_id', $elevesDeClasse)->count();
            $absencesJustifiees = Absence::whereIn('eleve_id', $elevesDeClasse)
                ->where('justifiee', true) // ← CORRIGÉ: 'justifiee'
                ->count();
            $totalHeures = $totalAbsences; // Pas de colonne nombre_heures

            $statsParClasse[] = [
                'classe' => $classe,
                'total_absences' => $totalAbsences,
                'absences_justifiees' => $absencesJustifiees,
                'taux_justification' => $totalAbsences > 0 ? round(($absencesJustifiees / $totalAbsences) * 100, 2) : 0,
                'total_heures' => $totalHeures
            ];
        }

        // Statistiques par mois
        $statsParMois = Absence::whereIn('eleve_id', $eleveIds)
            ->select(
                DB::raw('YEAR(date_absence) as annee'),
                DB::raw('MONTH(date_absence) as mois'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN justifiee = 1 THEN 1 ELSE 0 END) as justifiees'), // ← CORRIGÉ: 'justifiee'
                DB::raw('COUNT(*) as total_heures') // Pas de colonne nombre_heures
            )
            ->groupBy('annee', 'mois')
            ->orderBy('annee', 'desc')
            ->orderBy('mois', 'desc')
            ->limit(12)
            ->get();

        // Top 5 des élèves les plus absents
        $topElevesAbsents = Absence::whereIn('eleve_id', $eleveIds)
            ->select(
                'eleve_id',
                DB::raw('COUNT(*) as total_absences'),
                DB::raw('COUNT(*) as total_heures') // Pas de colonne nombre_heures
            )
            ->with('eleve')
            ->groupBy('eleve_id')
            ->orderBy('total_absences', 'desc')
            ->limit(5)
            ->get();

        return view('enseignant.absences-statistiques', compact(
            'statsParClasse',
            'statsParMois',
            'topElevesAbsents'
        ));
    }

    /**
     * Affiche le calendrier des absences
     */
    public function calendrier(Request $request)
    {
        $mois = $request->get('mois', now()->month);
        $annee = $request->get('annee', now()->year);

        $classeIds = EnseignantMatiereClasse::where('enseignant_id', $this->enseignant->id)
            ->distinct('classe_id')
            ->pluck('classe_id');

        $eleveIds = Inscription::whereIn('classe_id', $classeIds)
            ->where('statut', 'actif')
            ->pluck('eleve_id');

        $absences = Absence::whereIn('eleve_id', $eleveIds)
            ->whereYear('date_absence', $annee)
            ->whereMonth('date_absence', $mois)
            ->with(['eleve', 'matiere'])
            ->get()
            ->groupBy(function($absence) {
                return Carbon::parse($absence->date_absence)->format('Y-m-d');
            });

        return view('enseignant.absences-calendrier', compact('absences', 'mois', 'annee'));
    }
}