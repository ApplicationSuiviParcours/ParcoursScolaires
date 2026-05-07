<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\User;

class InscriptionController extends Controller
{
    /**
     * Affiche la liste des inscriptions
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        
        $query = Inscription::query()->with(['eleve', 'classe', 'anneeScolaire']);
        
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
        
        $inscriptions = $query->orderBy('date_inscription', 'desc')->paginate($perPage);
        
        // Pour les filtres
        $classes = Classe::query()->orderBy('nom')->get();
        $anneesScolaires = AnneeScolaire::query()->orderBy('nom', 'desc')->get();
        
        return view('admin.inscriptions.index', compact('inscriptions', 'classes', 'anneesScolaires'));
    }

    /**
     * Show the form for creating a new inscription.
     */
    public function create(Request $request)
    {
        $anneesScolaires = AnneeScolaire::query()->orderBy('nom', 'desc')->get();
        $classes = Classe::all();
        $eleves = Eleve::query()->where('statut', true)->orderBy('nom')->get();
        
        // Récupérer l'année scolaire active
        $anneeScolaireActive = AnneeScolaire::query()->where('active', true)->first();
        
        // Récupérer les paramètres de l'URL pour présélectionner
        $classe_id = $request->get('classe_id');
        $eleve_id = $request->get('eleve_id');
        
        return view('admin.inscriptions.create', compact(
            'anneesScolaires', 
            'classes', 
            'eleves',
            'anneeScolaireActive',
            'classe_id',
            'eleve_id'
        ));
    }

    /**
     * Store a newly created inscription in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'is_new_eleve' => 'required|boolean',
            'eleve_id' => 'required_if:is_new_eleve,0|nullable|exists:eleves,id',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'date_inscription' => 'required|date',
            'statut' => 'sometimes|boolean',
            'observation' => 'nullable|string',
            // Validation pour le nouvel élève
            'nom' => 'required_if:is_new_eleve,1|nullable|string|max:255',
            'prenom' => 'required_if:is_new_eleve,1|nullable|string|max:255',
            'date_naissance' => 'required_if:is_new_eleve,1|nullable|date',
            'lieu_naissance' => 'required_if:is_new_eleve,1|nullable|string|max:255',
            'genre' => 'required_if:is_new_eleve,1|nullable|in:M,F',
            'adresse' => 'required_if:is_new_eleve,1|nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            return \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                $eleveId = $request->eleve_id;

                // Si c'est un nouvel élève, on le crée d'abord
                if ($request->is_new_eleve == '1') {
                    $eleveData = [
                        'nom' => $request->nom,
                        'prenom' => $request->prenom,
                        'date_naissance' => $request->date_naissance,
                        'lieu_naissance' => $request->lieu_naissance,
                        'genre' => $request->genre,
                        'adresse' => $request->adresse,
                        'email' => $request->email,
                        'statut' => true,
                        'date_inscription' => $request->date_inscription,
                    ];

                    // Gérer la photo
                    if ($request->hasFile('photo')) {
                        $path = $request->file('photo')->store('eleves/photos', 'public');
                        $eleveData['photo'] = $path;
                    }

                    $eleve = Eleve::create($eleveData);
                    $eleveId = $eleve->id;
                }

                // ✅ VÉRIFICATION D'UNICITÉ : L'élève est-il déjà inscrit cette année ?
                $existingInscription = Inscription::query()->where('eleve_id', $eleveId)
                    ->where('annee_scolaire_id', $request->annee_scolaire_id)
                    ->first();

                if ($existingInscription) {
                    $classeExistante = Classe::find($existingInscription->classe_id);
                    $anneeExistante = AnneeScolaire::find($existingInscription->annee_scolaire_id);
                    
                    throw new \Exception('Cet élève est déjà inscrit pour l\'année scolaire ' . 
                                          $anneeExistante->nom . 
                                          ' dans la classe ' . 
                                          $classeExistante->nom);
                }

                // Vérifier la capacité de la classe
                $classe = Classe::find($request->classe_id);
                $nbInscriptions = Inscription::query()->where('classe_id', $request->classe_id)
                    ->where('annee_scolaire_id', $request->annee_scolaire_id)
                    ->count();

                if ($nbInscriptions >= $classe->capacite) {
                    throw new \Exception('Cette classe a atteint sa capacité maximale (' . $classe->capacite . ' élèves).');
                }

                // Créer l'inscription
                $inscription = Inscription::create([
                    'eleve_id' => $eleveId,
                    'classe_id' => $request->classe_id,
                    'annee_scolaire_id' => $request->annee_scolaire_id,
                    'date_inscription' => $request->date_inscription,
                    'statut' => $request->statut ?? true,
                    'observation' => $request->observation,
                ]);

                // ✅ AUTOMATIQUE: Créer un compte utilisateur pour le nouvel élève s'il n'en a pas
                $eleve = Eleve::find($eleveId);
                if (!$eleve->user_id) {
                    $email = $eleve->email ?? $eleve->matricule . '@scolaireparcours.com';
                    
                    // Vérifier l'unicité de l'email
                    if (User::where('email', $email)->exists()) {
                        $email = $eleve->matricule . '_' . rand(100, 999) . '@scolaireparcours.com';
                    }

                    $user = User::create([
                        'name' => $eleve->prenom . ' ' . $eleve->nom,
                        'email' => $email,
                        'password' => \Illuminate\Support\Facades\Hash::make('password'), // Mot de passe par défaut
                        'role' => 'eleve',
                        'is_active' => true,
                    ]);

                    $user->assignRole('eleve');
                    $eleve->update(['user_id' => $user->id]);
                }

                return redirect()
                    ->route('admin.inscriptions.index')
                    ->with('success', 'Inscription créée avec succès. Compte utilisateur généré automatiquement.');
            });
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified inscription.
     */
    public function show(Inscription $inscription)
    {
        $inscription->load(['eleve', 'classe', 'anneeScolaire']);
        return view('admin.inscriptions.show', compact('inscription'));
    }

    /**
     * Show the form for editing the specified inscription.
     */
    public function edit(Inscription $inscription)
    {
        $anneesScolaires = AnneeScolaire::query()->orderBy('nom', 'desc')->get();
        $classes = Classe::all();
        $eleves = Eleve::query()->where('statut', true)->orderBy('nom')->get();
        
        return view('admin.inscriptions.edit', compact('inscription', 'anneesScolaires', 'classes', 'eleves'));
    }

    /**
     * Update the specified inscription in storage.
     */
    public function update(Request $request, Inscription $inscription)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'classe_id' => 'required|exists:classes,id',
            // ✅ CORRECTION ICI AUSSI
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'date_inscription' => 'required|date',
            'statut' => 'sometimes|boolean',
            'observation' => 'nullable|string',
        ]);

        // ✅ VÉRIFICATION D'UNICITÉ (en excluant l'inscription actuelle)
        $existingInscription = Inscription::query()->where('eleve_id', $request->eleve_id)
            ->where('annee_scolaire_id', $request->annee_scolaire_id)
            ->where('id', '!=', $inscription->id)
            ->first();

        if ($existingInscription) {
            $classeExistante = Classe::find($existingInscription->classe_id);
            
            return back()
                ->withInput()
                ->withErrors([
                    'eleve_id' => 'Cet élève est déjà inscrit pour cette année scolaire dans la classe ' . $classeExistante->nom
                ]);
        }

        // Vérifier la capacité de la classe (en excluant cette inscription)
        $classe = Classe::find($request->classe_id);
        $nbInscriptions = Inscription::query()->where('classe_id', $request->classe_id)
            ->where('annee_scolaire_id', $request->annee_scolaire_id)
            ->where('id', '!=', $inscription->id)
            ->count();

        if ($nbInscriptions >= $classe->capacite) {
            return back()
                ->withInput()
                ->withErrors([
                    'classe_id' => 'Cette classe a atteint sa capacité maximale (' . $classe->capacite . ' élèves).'
                ]);
        }

        // Mise à jour
        $inscription->update([
            'eleve_id' => $request->eleve_id,
            'classe_id' => $request->classe_id,
            'annee_scolaire_id' => $request->annee_scolaire_id,
            'date_inscription' => $request->date_inscription,
            'statut' => $request->statut ?? $inscription->statut,
            'observation' => $request->observation,
        ]);

        return redirect()
            ->route('admin.inscriptions.show', $inscription)
            ->with('success', 'Inscription mise à jour avec succès.');
    }

    /**
     * Vérifier si un élève peut être inscrit (pour AJAX)
     */
    public function checkEligibility(Request $request)
    {
        $eleve_id = $request->get('eleve_id');
        $classe_id = $request->get('classe_id');
        $annee_scolaire_id = $request->get('annee_scolaire_id');
        $inscription_id = $request->get('inscription_id');

        if (!$eleve_id || !$classe_id || !$annee_scolaire_id) {
            return response()->json(['error' => 'Paramètres manquants'], 400);
        }

        // ✅ Vérifier si l'élève est déjà inscrit cette année
        $queryAnnee = Inscription::query()->where('eleve_id', $eleve_id)
            ->where('annee_scolaire_id', $annee_scolaire_id);
        
        if ($inscription_id) {
            $queryAnnee->where('id', '!=', $inscription_id);
        }
        
        $dejaInscritCetteAnnee = $queryAnnee->exists();
        
        // Vérifier si l'élève est déjà inscrit dans cette classe spécifiquement
        $queryClasse = Inscription::query()->where('eleve_id', $eleve_id)
            ->where('classe_id', $classe_id)
            ->where('annee_scolaire_id', $annee_scolaire_id);
        
        if ($inscription_id) {
            $queryClasse->where('id', '!=', $inscription_id);
        }
        
        $dejaInscritCetteClasse = $queryClasse->exists();

        // Vérifier les places disponibles
        $classe = Classe::find($classe_id);
        $queryPlaces = Inscription::query()->where('classe_id', $classe_id)
            ->where('annee_scolaire_id', $annee_scolaire_id);
        
        if ($inscription_id) {
            $queryPlaces->where('id', '!=', $inscription_id);
        }
        
        $nbInscriptions = $queryPlaces->count();
        $placesDisponibles = $classe ? ($classe->capacite - $nbInscriptions) : 0;

        // Déterminer le message
        $message = '';
        $peutInscrire = true;
        
        if ($dejaInscritCetteAnnee) {
            $message = '❌ Cet élève est déjà inscrit pour cette année scolaire.';
            $peutInscrire = false;
        } elseif ($dejaInscritCetteClasse) {
            $message = '❌ Cet élève est déjà inscrit dans cette classe.';
            $peutInscrire = false;
        } elseif ($placesDisponibles <= 0) {
            $message = '❌ Cette classe n\'a plus de places disponibles.';
            $peutInscrire = false;
        } else {
            $message = '✅ Éligible - ' . $placesDisponibles . ' place(s) disponible(s)';
        }

        return response()->json([
            'deja_inscrit_annee' => $dejaInscritCetteAnnee,
            'deja_inscrit_classe' => $dejaInscritCetteClasse,
            'deja_inscrit' => $dejaInscritCetteClasse || $dejaInscritCetteAnnee,
            'places_disponibles' => $placesDisponibles,
            'peut_inscrire' => $peutInscrire,
            'message' => $message
        ]);
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
     * Remove the specified inscription from storage.
     */
    public function destroy(Inscription $inscription)
    {
        $inscription->delete();

        return redirect()
            ->route('admin.inscriptions.index')
            ->with('success', 'Inscription supprimée avec succès.');
    }
}