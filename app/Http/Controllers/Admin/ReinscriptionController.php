<?php

namespace App\Http\Controllers\Admin;

use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Reinscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReinscriptionController extends Controller
{
    /**
     * Afficher la liste des réinscriptions
     */
    public function index(Request $request)
    {
        $query = Reinscription::with(['eleve', 'classe', 'anneeScolaire']);

        // Filtres
        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        }

        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('eleve', function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        // Tri
        $query->orderBy('created_at', 'desc');

        $reinscriptions = $query->paginate(15);

        // Données pour les filtres
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $classes = Classe::orderBy('nom')->get();
        $statuts = Reinscription::STATUTS;

        return view('admin.reinscriptions.index', compact(
            'reinscriptions', 
            'anneesScolaires', 
            'classes', 
            'statuts'
        ));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $eleves = Eleve::orderBy('nom')->orderBy('prenom')->get();
        $classes = Classe::orderBy('nom')->get();
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $statuts = Reinscription::STATUTS;

        return view('admin.reinscriptions.create', compact('eleves', 'classes', 'anneesScolaires', 'statuts'));
    }

    /**
     * Enregistrer une nouvelle réinscription
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annees_scolaires,id',
            'date_reinscription' => 'required|date',
            'statut' => 'required|in:en_attente,confirmee,annulee',
            'observation' => 'nullable|string|max:1000',
        ]);

        // Vérifier si l'élève a déjà une réinscription pour cette année
        $existing = Reinscription::where('eleve_id', $validated['eleve_id'])
            ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
            ->first();

        if ($existing) {
            return back()
                ->withInput()
                ->withErrors(['eleve_id' => 'Cet élève a déjà une réinscription pour cette année scolaire.']);
        }

        Reinscription::create($validated);

        return redirect()
            ->route('admin.reinscriptions.index')
            ->with('success', 'Réinscription créée avec succès.');
    }

    /**
     * Afficher les détails d'une réinscription
     */
    public function show(Reinscription $reinscription)
    {
        $reinscription->load(['eleve', 'classe', 'anneeScolaire']);
        
        return view('admin.reinscriptions.show', compact('reinscription'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Reinscription $reinscription)
    {
        $classes = Classe::orderBy('nom')->get();
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        $statuts = Reinscription::STATUTS;

        return view('admin.reinscriptions.edit', compact('reinscription', 'classes', 'anneesScolaires', 'statuts'));
    }

    /**
     * Mettre à jour une réinscription
     */
    public function update(Request $request, Reinscription $reinscription)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'date_reinscription' => 'required|date',
            'statut' => 'required|in:en_attente,confirmee,annulee',
            'observation' => 'nullable|string|max:1000',
        ]);

        $reinscription->update($validated);

        return redirect()
            ->route('admin.reinscriptions.index')
            ->with('success', 'Réinscription mise à jour avec succès.');
    }

    /**
     * Supprimer une réinscription
     */
    public function destroy(Reinscription $reinscription)
    {
        $reinscription->delete();

        return redirect()
            ->route('admin.reinscriptions.index')
            ->with('success', 'Réinscription supprimée avec succès.');
    }
}