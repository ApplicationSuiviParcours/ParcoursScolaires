<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Inscription;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClassesExport;

class ClasseController extends Controller
{
    /**
     * Affiche la liste des classes
     */
    public function index(Request $request)
    {
        $query = Classe::with('anneeScolaire');
        
        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('niveau', 'like', "%{$search}%")
                  ->orWhere('serie', 'like', "%{$search}%");
            });
        }
        
        // Filtre par niveau
        if ($request->filled('niveau')) {
            $query->where('niveau', $request->niveau);
        }
        
        // Filtre par année scolaire
        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        }
        
        $classes = $query->orderBy('niveau')->orderBy('nom')->paginate(15);
        
        // ✅ Calculer le nombre d'élèves pour chaque classe et les totaux
        $totalEleves = 0;
        $totalCapacite = 0;
        
        foreach ($classes as $classe) {
            $classe->eleves_count = Inscription::where('classe_id', $classe->id)
                ->where('annee_scolaire_id', $classe->annee_scolaire_id)
                ->where('statut', true) // Seulement les inscriptions actives
                ->count();
            
            $totalEleves += $classe->eleves_count;
            $totalCapacite += $classe->capacite;
        }
        
        // ✅ Calculer le taux d'occupation global
        $tauxOccupationGlobal = $totalCapacite > 0 ? round(($totalEleves / $totalCapacite) * 100) : 0;
        
        $anneeScolaire = AnneeScolaire::where('active', true)->first();
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        
        return view('admin.classes.index', compact(
            'classes', 
            'anneeScolaire', 
            'anneesScolaires',
            'tauxOccupationGlobal',
            'totalEleves',
            'totalCapacite'
        ));
    }

    /**
     * Affiche le formulaire de création d'une classe
     */
    public function create()
    {
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        return view('admin.classes.create', compact('anneesScolaires'));
    }

    /**
     * Enregistre une nouvelle classe
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'required|string|max:50',
            'serie' => 'nullable|string|max:50',
            'capacite' => 'required|integer|min:1|max:60',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
        ]);

        Classe::create($request->all());

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe créée avec succès.');
    }

    /**
     * Affiche les détails d'une classe
     */
    public function show(Classe $classe)
    {
        $classe->load('anneeScolaire');
        
        // Ne récupérer que les inscriptions actives
        $inscriptions = $classe->inscriptions()
            ->with('eleve')
            ->where('annee_scolaire_id', $classe->annee_scolaire_id)
            ->where('statut', true)
            ->get();
        
        // Calculer les statistiques
        $totalEleves = $inscriptions->count();
        $placesDisponibles = $classe->capacite - $totalEleves;
        $tauxOccupation = $classe->capacite > 0 ? round(($totalEleves / $classe->capacite) * 100) : 0;
        
        $stats = [
            'total_eleves' => $totalEleves,
            'places_disponibles' => $placesDisponibles,
            'taux_occupation' => $tauxOccupation,
            'garcons' => $inscriptions->filter(function($inscription) {
                return $inscription->eleve && $inscription->eleve->genre === 'M';
            })->count(),
            'filles' => $inscriptions->filter(function($inscription) {
                return $inscription->eleve && $inscription->eleve->genre === 'F';
            })->count(),
        ];
        
        return view('admin.classes.show', compact('classe', 'inscriptions', 'stats'));
    }

    /**
     * Affiche le formulaire d'édition d'une classe
     */
    public function edit(Classe $classe)
    {
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        return view('admin.classes.edit', compact('classe', 'anneesScolaires'));
    }

    /**
     * Met à jour une classe
     */
    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'required|string|max:50',
            'serie' => 'nullable|string|max:50',
            'capacite' => 'required|integer|min:1|max:60',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
        ]);

        // Vérifier que la capacité est suffisante
        $nbEleves = Inscription::where('classe_id', $classe->id)
            ->where('annee_scolaire_id', $classe->annee_scolaire_id)
            ->where('statut', true)
            ->count();
            
        if ($request->capacite < $nbEleves) {
            return back()->withInput()
                ->with('error', 'La capacité ne peut pas être inférieure au nombre d\'élèves actuellement inscrits (' . $nbEleves . ' élèves).');
        }

        $classe->update($request->all());

        return redirect()->route('admin.classes.show', $classe)
            ->with('success', 'Classe mise à jour avec succès.');
    }

    /**
     * Supprime une classe
     */
    public function destroy(Classe $classe)
    {
        // Vérifier s'il y a des inscriptions actives dans cette classe
        if ($classe->inscriptions()->where('statut', true)->exists()) {
            return redirect()->route('admin.classes.index')
                ->with('error', 'Impossible de supprimer cette classe car elle contient des élèves inscrits.');
        }

        $classe->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe supprimée avec succès.');
    }

    /**
     * Affiche la liste des élèves d'une classe
     */
    public function eleves(Classe $classe)
    {
        $inscriptions = $classe->inscriptions()
            ->with('eleve')
            ->where('annee_scolaire_id', $classe->annee_scolaire_id)
            ->where('statut', true)
            ->paginate(15);

        return view('admin.classes.eleves', compact('classe', 'inscriptions'));
    }

    /**
     * Affiche l'emploi du temps d'une classe
     */
    public function emplois(Classe $classe)
    {
        $emplois = $classe->emploisDuTemps()
            ->with(['matiere', 'professeur', 'salle'])
            ->orderBy('jour_semaine')
            ->orderBy('heure_debut')
            ->get();

        return view('admin.classes.emplois', compact('classe', 'emplois'));
    }

    /**
     * Duplique une classe (pour la nouvelle année scolaire)
     */
    public function duplicate(Classe $classe)
    {
        try {
            // Récupérer la nouvelle année scolaire active
            $nouvelleAnnee = AnneeScolaire::where('active', true)->first();
            
            if (!$nouvelleAnnee) {
                return back()->with('error', 'Aucune année scolaire active trouvée.');
            }

            // Vérifier si une classe similaire n'existe pas déjà
            $existingClasse = Classe::where('nom', $classe->nom)
                ->where('niveau', $classe->niveau)
                ->where('annee_scolaire_id', $nouvelleAnnee->id)
                ->first();

            if ($existingClasse) {
                return back()->with('error', 'Une classe similaire existe déjà pour cette année scolaire.');
            }

            // Créer la nouvelle classe
            $nouvelleClasse = Classe::create([
                'niveau' => $classe->niveau,
                'nom' => $classe->nom,
                'serie' => $classe->serie,
                'capacite' => $classe->capacite,
                'active' => true,
                'annee_scolaire_id' => $nouvelleAnnee->id
            ]);

            return redirect()->route('admin.classes.edit', $nouvelleClasse)
                ->with('success', 'Classe dupliquée avec succès pour la nouvelle année scolaire.');

        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la duplication de la classe.');
        }
    }

    // ============ MÉTHODES D'EXPORT ============

    /**
     * Exporter toutes les classes au format PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Classe::with('anneeScolaire');
        
        // Appliquer les filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('niveau', 'like', "%{$search}%")
                  ->orWhere('serie', 'like', "%{$search}%");
            });
        }

        if ($request->filled('niveau')) {
            $query->where('niveau', $request->niveau);
        }

        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        }

        $classes = $query->orderBy('niveau')->orderBy('nom')->get();

        // Calculer le nombre d'élèves pour chaque classe via les inscriptions
        $totalEleves = 0;
        $totalCapacite = 0;
        
        foreach ($classes as $classe) {
            $classe->eleves_count = Inscription::where('classe_id', $classe->id)
                ->where('annee_scolaire_id', $classe->annee_scolaire_id)
                ->where('statut', true)
                ->count();
            
            $totalEleves += $classe->eleves_count;
            $totalCapacite += $classe->capacite;
        }

        // Calculer les statistiques
        $stats = [
            'total' => $classes->count(),
            'capacite_totale' => $totalCapacite,
            'total_eleves' => $totalEleves,
            'niveaux' => $classes->pluck('niveau')->unique()->count(),
            'series' => $classes->pluck('serie')->filter()->unique()->count(),
            'taux_occupation_moyen' => $totalCapacite > 0 
                ? round(($totalEleves / $totalCapacite) * 100) 
                : 0
        ];

        // Récupérer l'année scolaire pour le titre
        $anneeScolaire = null;
        if ($request->filled('annee_scolaire_id')) {
            $anneeScolaire = AnneeScolaire::find($request->annee_scolaire_id);
        } else {
            $anneeScolaire = AnneeScolaire::where('active', true)->first();
        }

        $pdf = Pdf::loadView('admin.classes.exports.pdf', compact('classes', 'stats', 'anneeScolaire'));

        // Personnaliser le nom du fichier
        $filename = 'classes';
        if ($anneeScolaire) {
            $filename .= '_' . str_replace('/', '-', $anneeScolaire->nom);
        }
        $filename .= '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Exporter toutes les classes au format Excel
     */
    public function exportExcel(Request $request)
    {
        $filename = 'classes';
        
        if ($request->filled('annee_scolaire_id')) {
            $anneeScolaire = AnneeScolaire::find($request->annee_scolaire_id);
            if ($anneeScolaire) {
                $filename .= '_' . str_replace('/', '-', $anneeScolaire->nom);
            }
        } else {
            $anneeScolaire = AnneeScolaire::where('active', true)->first();
            if ($anneeScolaire) {
                $filename .= '_' . str_replace('/', '-', $anneeScolaire->nom);
            }
        }
        
        $filename .= '_' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new ClassesExport($request), $filename);
    }

    /**
     * Générer un PDF pour une classe spécifique
     */
    public function generatePdf(Classe $classe)
    {
        $classe->load('anneeScolaire');
        
        // Récupérer les élèves via les inscriptions
        $inscriptions = Inscription::where('classe_id', $classe->id)
            ->where('annee_scolaire_id', $classe->annee_scolaire_id)
            ->where('statut', true)
            ->with('eleve')
            ->get();
        
        $eleves = $inscriptions->pluck('eleve')->filter();
        
        // Trier les élèves par nom et prénom
        $eleves = $eleves->sortBy([
            ['nom', 'asc'],
            ['prenom', 'asc']
        ]);
        
        $totalEleves = $eleves->count();
        $placesDisponibles = $classe->capacite - $totalEleves;
        $tauxOccupation = $classe->capacite > 0 ? round(($totalEleves / $classe->capacite) * 100) : 0;
        
        // Compter par genre
        $garcons = $eleves->where('genre', 'M')->count();
        $filles = $eleves->where('genre', 'F')->count();
        
        $stats = [
            'total_eleves' => $totalEleves,
            'places_disponibles' => $placesDisponibles,
            'taux_occupation' => $tauxOccupation,
            'capacite' => $classe->capacite,
            'garcons' => $garcons,
            'filles' => $filles,
        ];
        
        $pdf = Pdf::loadView('admin.classes.exports.single-pdf', compact('classe', 'stats', 'eleves'));
        
        $filename = 'classe_' . $classe->niveau . '_' . $classe->nom;
        if ($classe->serie) {
            $filename .= '_' . $classe->serie;
        }
        $filename .= '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Exporter la liste des élèves d'une classe au format PDF
     */
    public function exportElevesPdf(Classe $classe)
    {
        // Utiliser une jointure pour trier directement
        $eleves = Eleve::join('inscriptions', 'eleves.id', '=', 'inscriptions.eleve_id')
            ->where('inscriptions.classe_id', $classe->id)
            ->where('inscriptions.annee_scolaire_id', $classe->annee_scolaire_id)
            ->where('inscriptions.statut', true)
            ->orderBy('eleves.nom')
            ->orderBy('eleves.prenom')
            ->select('eleves.*')
            ->get();

        $stats = [
            'total' => $eleves->count(),
            'garcons' => $eleves->where('genre', 'M')->count(),
            'filles' => $eleves->where('genre', 'F')->count(),
        ];
        
        $pdf = Pdf::loadView('admin.classes.exports.eleves-pdf', compact('classe', 'stats', 'eleves'));
        
        $filename = 'eleves_' . $classe->niveau . '_' . $classe->nom . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Obtenir les statistiques complètes pour le dashboard
     */
    private function getStats(Request $request = null)
    {
        $query = Classe::query();
        
        if ($request && $request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        } else {
            $anneeScolaire = AnneeScolaire::where('active', true)->first();
            if ($anneeScolaire) {
                $query->where('annee_scolaire_id', $anneeScolaire->id);
            }
        }
        
        $classes = $query->get();
        
        // Compter les élèves via les inscriptions
        $totalEleves = 0;
        foreach ($classes as $classe) {
            $classe->eleves_count = Inscription::where('classe_id', $classe->id)
                ->where('annee_scolaire_id', $classe->annee_scolaire_id)
                ->where('statut', true)
                ->count();
            $totalEleves += $classe->eleves_count;
        }
        
        return [
            'total_classes' => $classes->count(),
            'capacite_totale' => $classes->sum('capacite'),
            'total_eleves' => $totalEleves,
            'taux_occupation_global' => $classes->sum('capacite') > 0 
                ? round(($totalEleves / $classes->sum('capacite')) * 100) 
                : 0,
            'repartition_niveaux' => $classes->groupBy('niveau')
                ->map(function ($item) {
                    return [
                        'count' => $item->count(),
                        'eleves' => $item->sum('eleves_count'),
                        'capacite' => $item->sum('capacite')
                    ];
                }),
            'classes_actives' => $classes->where('active', true)->count(),
            'classes_inactives' => $classes->where('active', false)->count(),
        ];
    }
}