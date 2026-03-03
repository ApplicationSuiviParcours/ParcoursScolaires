<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Inscription;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // Récupérer l'année scolaire active
        $anneeScolaire = AnneeScolaire::where('active', true)->first();
        
        // Construire la requête de base
        $query = Classe::with('anneeScolaire');
        
        // Appliquer les filtres de recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%')
                  ->orWhere('niveau', 'like', '%' . $search . '%')
                  ->orWhere('serie', 'like', '%' . $search . '%');
            });
        }
        
        // Filtre par niveau
        if ($request->has('niveau') && !empty($request->niveau)) {
            $query->where('niveau', $request->niveau);
        }
        
        // Filtre par année scolaire
        if ($request->has('annee_scolaire_id') && !empty($request->annee_scolaire_id)) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        } elseif ($anneeScolaire) {
            // Par défaut, filtrer par année scolaire active
            $query->where('annee_scolaire_id', $anneeScolaire->id);
        }
        
        // Récupérer les classes avec pagination
        $classes = $query->orderBy('niveau')
            ->orderBy('nom')
            ->paginate(10);
        
        // ✅ Calculer le nombre d'élèves pour chaque classe
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
        
        // Récupérer toutes les années scolaires pour le filtre
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
        // Récupérer l'année scolaire active
        $anneeScolaire = AnneeScolaire::where('active', true)->first();
        
        if (!$anneeScolaire) {
            return redirect()->route('admin.classes.index')
                ->with('error', 'Vous devez d\'abord créer une année scolaire active.');
        }

        return view('admin.classes.create', compact('anneeScolaire'));
    }

    /**
     * Enregistre une nouvelle classe
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'niveau' => 'required|string|max:50',
            'nom' => 'required|string|max:50',
            'serie' => 'nullable|string|max:10',
            'capacite' => 'required|integer|min:1|max:100',
            'active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Récupérer l'année scolaire active
            $anneeScolaire = AnneeScolaire::where('active', true)->first();
            
            if (!$anneeScolaire) {
                return back()->withInput()
                    ->with('error', 'Aucune année scolaire active trouvée.');
            }

            // Vérifier si une classe avec le même nom existe déjà pour cette année
            $existingClasse = Classe::where('nom', $validated['nom'])
                ->where('niveau', $validated['niveau'])
                ->where('annee_scolaire_id', $anneeScolaire->id)
                ->first();

            if ($existingClasse) {
                return back()->withInput()
                    ->with('error', 'Une classe avec ce nom et ce niveau existe déjà pour cette année scolaire.');
            }

            // Créer la classe
            $classe = Classe::create([
                'niveau' => $validated['niveau'],
                'nom' => $validated['nom'],
                'serie' => $validated['serie'] ?? null,
                'capacite' => $validated['capacite'],
                'active' => $validated['active'] ?? true,
                'annee_scolaire_id' => $anneeScolaire->id
            ]);

            DB::commit();

            return redirect()->route('admin.classes.index')
                ->with('success', 'Classe créée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de la classe.');
        }
    }

    /**
     * Affiche les détails d'une classe
     */
    public function show(Classe $classe)
    {
        // Charger les relations
        $classe->load(['anneeScolaire']);
        
        // Récupérer les élèves via les inscriptions
        $inscriptions = Inscription::where('classe_id', $classe->id)
            ->where('annee_scolaire_id', $classe->annee_scolaire_id)
            ->where('statut', true)
            ->with('eleve')
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
        // Récupérer toutes les années scolaires pour le sélecteur
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        
        return view('admin.classes.edit', compact('classe', 'anneesScolaires'));
    }

    /**
     * Met à jour une classe
     */
    public function update(Request $request, Classe $classe)
    {
        $validated = $request->validate([
            'niveau' => 'required|string|max:50',
            'nom' => 'required|string|max:50',
            'serie' => 'nullable|string|max:10',
            'capacite' => 'required|integer|min:1|max:100',
            'active' => 'boolean',
            'annee_scolaire_id' => 'required|exists:annees_scolaires,id'
        ]);

        try {
            DB::beginTransaction();

            // Vérifier si une autre classe avec le même nom existe (sauf celle-ci)
            $existingClasse = Classe::where('nom', $validated['nom'])
                ->where('niveau', $validated['niveau'])
                ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
                ->where('id', '!=', $classe->id)
                ->first();

            if ($existingClasse) {
                return back()->withInput()
                    ->with('error', 'Une autre classe avec ce nom et ce niveau existe déjà pour cette année scolaire.');
            }

            // Vérifier que la nouvelle capacité est suffisante pour les élèves existants
            $nbEleves = Inscription::where('classe_id', $classe->id)
                ->where('annee_scolaire_id', $classe->annee_scolaire_id)
                ->where('statut', true)
                ->count();
                
            if ($validated['capacite'] < $nbEleves) {
                return back()->withInput()
                    ->with('error', 'La capacité ne peut pas être inférieure au nombre d\'élèves actuellement inscrits (' . $nbEleves . ' élèves).');
            }

            // Mettre à jour la classe
            $classe->update([
                'niveau' => $validated['niveau'],
                'nom' => $validated['nom'],
                'serie' => $validated['serie'] ?? null,
                'capacite' => $validated['capacite'],
                'active' => $validated['active'] ?? true,
                'annee_scolaire_id' => $validated['annee_scolaire_id']
            ]);

            DB::commit();

            return redirect()->route('admin.classes.index')
                ->with('success', 'Classe mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour de la classe.');
        }
    }

    /**
     * Supprime une classe
     */
    public function destroy(Classe $classe)
    {
        try {
            DB::beginTransaction();

            // Vérifier si la classe a des élèves via les inscriptions
            $nbEleves = Inscription::where('classe_id', $classe->id)
                ->where('annee_scolaire_id', $classe->annee_scolaire_id)
                ->where('statut', true)
                ->count();
                
            if ($nbEleves > 0) {
                return back()->with('error', 'Impossible de supprimer une classe qui contient des élèves.');
            }

            // Vérifier si la classe a des emplois du temps
            if ($classe->emploisDuTemps()->count() > 0) {
                return back()->with('error', 'Impossible de supprimer une classe qui a des emplois du temps associés.');
            }

            $classe->delete();

            DB::commit();

            return redirect()->route('admin.classes.index')
                ->with('success', 'Classe supprimée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la suppression de la classe.');
        }
    }

    /**
     * Affiche la liste des élèves d'une classe
     */
    public function eleves(Classe $classe)
    {
        $inscriptions = Inscription::where('classe_id', $classe->id)
            ->where('annee_scolaire_id', $classe->annee_scolaire_id)
            ->where('statut', true)
            ->with('eleve')
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
            DB::beginTransaction();

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

            DB::commit();

            return redirect()->route('admin.classes.edit', $nouvelleClasse)
                ->with('success', 'Classe dupliquée avec succès pour la nouvelle année scolaire.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la duplication de la classe.');
        }
    }

    // ============ MÉTHODES D'EXPORT ============

    /**
     * Exporter toutes les classes au format PDF
     */
    public function exportPdf(Request $request)
    {
        // Construire la requête avec les filtres
        $query = Classe::with('anneeScolaire');
        
        // Appliquer les filtres de recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%')
                  ->orWhere('niveau', 'like', '%' . $search . '%')
                  ->orWhere('serie', 'like', '%' . $search . '%');
            });
        }
        
        // Filtre par niveau
        if ($request->has('niveau') && !empty($request->niveau)) {
            $query->where('niveau', $request->niveau);
        }
        
        // Filtre par année scolaire
        if ($request->has('annee_scolaire_id') && !empty($request->annee_scolaire_id)) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        } else {
            // Par défaut, filtrer par année scolaire active
            $anneeScolaire = AnneeScolaire::where('active', true)->first();
            if ($anneeScolaire) {
                $query->where('annee_scolaire_id', $anneeScolaire->id);
            }
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
        if ($request->has('annee_scolaire_id') && !empty($request->annee_scolaire_id)) {
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
        
        // Ajouter le filtre d'année au nom du fichier
        if ($request->has('annee_scolaire_id') && !empty($request->annee_scolaire_id)) {
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
        // Charger les relations nécessaires
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
        
        // Calculer les statistiques
        $totalEleves = $eleves->count();
        $placesDisponibles = $classe->capacite - $totalEleves;
        $tauxOccupation = $classe->capacite > 0 ? round(($totalEleves / $classe->capacite) * 100) : 0;
        
        // Statistiques supplémentaires
        $stats = [
            'total_eleves' => $totalEleves,
            'places_disponibles' => $placesDisponibles,
            'taux_occupation' => $tauxOccupation,
            'capacite' => $classe->capacite,
            'garcons' => $eleves->where('genre', 'M')->count(),
            'filles' => $eleves->where('genre', 'F')->count(),
        ];
        
        $pdf = Pdf::loadView('admin.classes.exports.single-pdf', compact('classe', 'stats', 'eleves'));
        
        // Personnaliser le nom du fichier
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
        // Utiliser une jointure (recommandée pour les grandes tables)
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
        
        if ($request && $request->has('annee_scolaire_id') && !empty($request->annee_scolaire_id)) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        } else {
            $anneeScolaire = AnneeScolaire::where('active', true)->first();
            if ($anneeScolaire) {
                $query->where('annee_scolaire_id', $anneeScolaire->id);
            }
        }
        
        $classes = $query->get();
        
        // Calculer le nombre d'élèves pour chaque classe via les inscriptions
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