<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscriptionController extends Controller
{
    /**
     * Afficher la liste des inscriptions
     */
    public function index(Request $request)
    {
        $query = Inscription::with(['eleve', 'classe', 'anneeScolaire']);
        
        // Filtres
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }
        
        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        }
        
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $inscriptions = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $classes = Classe::orderBy('nom')->get();
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        
        return view('admin.inscriptions.index', compact(
            'inscriptions', 
            'classes', 
            'anneesScolaires'
        ));
    }

    /**
     * Formulaire de création d'inscription
     */
    public function create(Request $request)
    {
        $classe_id = $request->get('classe_id');
        $eleve_id = $request->get('eleve_id');
        
        $classes = Classe::orderBy('nom')->get();
        $eleves = Eleve::orderBy('nom')->orderBy('prenom')->get();
        $anneeScolaireActive = AnneeScolaire::where('statut', true)->first();
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        
        return view('admin.inscriptions.create', compact(
            'classes', 
            'eleves', 
            'anneeScolaireActive', 
            'anneesScolaires',
            'classe_id',
            'eleve_id'
        ));
    }

    /**
     * Enregistrer une nouvelle inscription
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annees_scolaires,id',
            'date_inscription' => 'required|date',
            'statut' => 'sometimes|boolean',
            'observation' => 'nullable|string|max:500',
        ]);

        if (!isset($validated['statut'])) {
            $validated['statut'] = true;
        }

        // Vérifier si l'élève est déjà inscrit
        $exists = Inscription::where('eleve_id', $validated['eleve_id'])
            ->where('classe_id', $validated['classe_id'])
            ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'eleve_id' => 'Cet élève est déjà inscrit dans cette classe pour cette année scolaire.'
            ]);
        }

        // Vérifier la capacité de la classe
        $classe = Classe::find($validated['classe_id']);
        $nbInscriptions = Inscription::where('classe_id', $validated['classe_id'])
            ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
            ->count();

        if ($nbInscriptions >= $classe->capacite) {
            return back()->withInput()->withErrors([
                'classe_id' => 'Cette classe a atteint sa capacité maximale (' . $classe->capacite . ' élèves).'
            ]);
        }

        $inscription = Inscription::create($validated);

        return redirect()
            ->route('admin.inscriptions.show', $inscription)
            ->with('success', 'Inscription créée avec succès.');
    }

    /**
     * Afficher les détails d'une inscription
     */
    public function show(Inscription $inscription)
    {
        $inscription->load(['eleve', 'classe', 'anneeScolaire']);
        return view('admin.inscriptions.show', compact('inscription'));
    }

    /**
     * Formulaire d'édition d'une inscription
     */
    public function edit(Inscription $inscription)
    {
        $classes = Classe::orderBy('nom')->get();
        $eleves = Eleve::orderBy('nom')->orderBy('prenom')->get();
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        
        return view('admin.inscriptions.edit', compact('inscription', 'classes', 'eleves', 'anneesScolaires'));
    }

    /**
     * Mettre à jour une inscription
     */
    public function update(Request $request, Inscription $inscription)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annees_scolaires,id',
            'date_inscription' => 'required|date',
            'statut' => 'sometimes|boolean',
            'observation' => 'nullable|string|max:500',
        ]);

        if (!isset($validated['statut'])) {
            $validated['statut'] = $inscription->statut;
        }

        // Vérifier si une autre inscription existe déjà (sauf celle-ci)
        $exists = Inscription::where('eleve_id', $validated['eleve_id'])
            ->where('classe_id', $validated['classe_id'])
            ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
            ->where('id', '!=', $inscription->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'eleve_id' => 'Cet élève est déjà inscrit dans cette classe pour cette année scolaire.'
            ]);
        }

        // Vérifier la capacité de la classe (en excluant cette inscription)
        $classe = Classe::find($validated['classe_id']);
        $nbInscriptions = Inscription::where('classe_id', $validated['classe_id'])
            ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
            ->where('id', '!=', $inscription->id)
            ->count();

        if ($nbInscriptions >= $classe->capacite) {
            return back()->withInput()->withErrors([
                'classe_id' => 'Cette classe a atteint sa capacité maximale (' . $classe->capacite . ' élèves).'
            ]);
        }

        $inscription->update($validated);

        return redirect()
            ->route('admin.inscriptions.show', $inscription)
            ->with('success', 'Inscription mise à jour avec succès.');
    }

    /**
     * Supprimer une inscription
     */
    public function destroy(Inscription $inscription)
    {
        $inscription->delete();

        return redirect()
            ->route('admin.inscriptions.index')
            ->with('success', 'Inscription supprimée avec succès.');
    }

    /**
     * Activer/Désactiver le statut d'une inscription
     */
    public function toggleStatus(Inscription $inscription)
    {
        $inscription->statut = !$inscription->statut;
        $inscription->save();

        return back()->with('success', 
            $inscription->statut ? 'Inscription activée avec succès.' : 'Inscription désactivée avec succès.'
        );
    }

    /**
 * Vérifier si un élève peut être inscrit dans une classe
 */
public function checkEligibility(Request $request)
{
    $eleve_id = $request->get('eleve_id');
    $classe_id = $request->get('classe_id');
    $annee_scolaire_id = $request->get('annee_scolaire_id');

    if (!$eleve_id || !$classe_id || !$annee_scolaire_id) {
        return response()->json(['error' => 'Paramètres manquants'], 400);
    }

    // Vérifier si l'élève est déjà inscrit
    $dejaInscrit = Inscription::where('eleve_id', $eleve_id)
        ->where('classe_id', $classe_id)
        ->where('annee_scolaire_id', $annee_scolaire_id)
        ->exists();

    // Vérifier les places disponibles
    $classe = Classe::find($classe_id);
    $nbInscriptions = Inscription::where('classe_id', $classe_id)
        ->where('annee_scolaire_id', $annee_scolaire_id)
        ->count();
    
    $placesDisponibles = $classe ? ($classe->capacite - $nbInscriptions) : 0;

    return response()->json([
        'deja_inscrit' => $dejaInscrit,
        'places_disponibles' => $placesDisponibles,
        'peut_inscrire' => !$dejaInscrit && $placesDisponibles > 0
    ]);
}
}