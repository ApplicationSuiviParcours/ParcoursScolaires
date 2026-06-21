<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\AnneeScolaire;
use App\Models\Reinscription;
use App\Models\ParentEleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\CompteUtilisateurCree;

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
        $parents = ParentEleve::orderBy('nom')->orderBy('prenom')->get();
        $anneeScolaireActive = AnneeScolaire::where('statut', true)->first();
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();
        
        return view('admin.inscriptions.create', compact(
            'classes', 
            'eleves', 
            'parents',
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
        $isNewEleve = $request->boolean('is_new_eleve');

        $rules = [
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annees_scolaires,id',
            'date_inscription' => 'required|date',
            'statut' => 'sometimes|boolean',
            'observation' => 'nullable|string|max:500',
        ];

        if ($isNewEleve) {
            $rules += [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'date_naissance' => 'required|date',
                'lieu_naissance' => 'required|string|max:255',
                'genre' => 'required|in:m,f,M,F,Masculin,Féminin',
                'adresse' => 'required|string|max:255',
                'email' => 'nullable|email|unique:users,email|unique:eleves,email',
                'parent_id' => 'nullable|exists:parent_eleves,id',
            ];
        } else {
            $rules['eleve_id'] = 'required|exists:eleves,id';
        }

        $validated = $request->validate($rules);

        if (!isset($validated['statut'])) {
            $validated['statut'] = true;
        }

        try {
            return DB::transaction(function () use ($validated, $isNewEleve) {
                if ($isNewEleve) {
                    // Générer le matricule à l'avance pour l'utiliser comme login si besoin
                    $matricule = Eleve::genererMatricule($validated['nom']);
                    
                    // Création du compte utilisateur automatique
                    $email = $validated['email'] ?? strtolower($matricule) . '@scolaireparcours.com';
                    
                    $motDePasse = Str::random(10);

                    $user = \App\Models\User::create([
                        'name'     => $validated['prenom'] . ' ' . $validated['nom'],
                        'email'    => $email,
                        'password' => \Illuminate\Support\Facades\Hash::make($motDePasse),
                        'statut'   => true,
                    ]);

                    // Attribuer le rôle élève
                    $user->assignRole('eleve');

                    // Envoi de l'email avec les identifiants
                    // On n'envoie que si l'élève a une vraie adresse email (pas une adresse fictive générée)
                    $aVraiEmail = !empty($validated['email'])
                        && !str_ends_with($email, '@scolaireparcours.com');

                    if ($aVraiEmail) {
                        try {
                            Mail::to($email)->send(new CompteUtilisateurCree(
                                $validated['prenom'] . ' ' . $validated['nom'],
                                $email,
                                $motDePasse,
                                'eleve',
                                $matricule
                            ));
                        } catch (\Exception $mailException) {
                            \Log::warning('Email non envoyé pour ' . $email . ' : ' . $mailException->getMessage());
                            session()->flash('warning', '⚠️ Le compte a été créé mais l\'email n\'a pas pu être envoyé à ' . $email . '. Vérifiez la configuration SMTP.');
                        }
                    } else {
                        \Log::info('Pas d\'email envoyé pour ' . $email . ' : adresse non renseignée ou fictive.');
                        session()->flash('warning', '⚠️ Aucun email n\'a été envoyé car cet élève n\'a pas d\'adresse email réelle. Pensez à la renseigner dans son profil.');
                    }

                    // Création de l'élève
                    $eleve = Eleve::create([
                        'user_id' => $user->id,
                        'nom' => $validated['nom'],
                        'prenom' => $validated['prenom'],
                        'matricule' => $matricule,
                        'date_naissance' => $validated['date_naissance'],
                        'lieu_naissance' => $validated['lieu_naissance'],
                        'genre' => in_array(strtolower($validated['genre']), ['m', 'masculin']) ? 'm' : 'f',
                        'adresse' => $validated['adresse'],
                        'email' => $email,
                        'date_inscription' => $validated['date_inscription'],
                        'statut' => true,
                    ]);
                    $eleve_id = $eleve->id;

                    // Associer au parent si fourni
                    if (!empty($validated['parent_id'])) {
                        $eleve->parents()->attach($validated['parent_id'], ['lien_parental' => 'Parent']);
                    }

                    // Vérifier si l'élève est déjà inscrit pour cette année
                    $exists = Inscription::query()->where('eleve_id', $eleve_id)
                        ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
                        ->exists();

                    if ($exists) {
                        throw new \Exception('Cet élève est déjà inscrit pour cette année scolaire.');
                    }

                    // Vérifier la capacité de la classe
                    $classe = Classe::findOrFail($validated['classe_id']);
                    $nbInscriptions = Inscription::query()->where('classe_id', $validated['classe_id'])
                        ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
                        ->count();

                    if ($nbInscriptions >= $classe->capacite) {
                        throw new \Exception('Cette classe a atteint sa capacité maximale (' . $classe->capacite . ' élèves).');
                    }

                    $inscription = Inscription::create([
                        'eleve_id' => $eleve_id,
                        'classe_id' => $validated['classe_id'],
                        'annee_scolaire_id' => $validated['annee_scolaire_id'],
                        'date_inscription' => $validated['date_inscription'],
                        'statut' => $validated['statut'],
                        'observation' => $validated['observation'] ?? null,
                    ]);

                    return redirect()
                        ->route('admin.inscriptions.show', $inscription)
                        ->with('success', 'Inscription et création du compte réussies.');

                } else {
                    // Pour un élève existant, c'est une réinscription
                    $eleve_id = $validated['eleve_id'];

                    // Vérifier si la réinscription existe déjà
                    $exists = Reinscription::query()->where('eleve_id', $eleve_id)
                        ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
                        ->exists();

                    if ($exists) {
                        throw new \Exception('Cet élève a déjà une réinscription pour cette année scolaire.');
                    }

                    // On peut aussi vérifier la capacité
                    $classe = Classe::findOrFail($validated['classe_id']);
                    $nbInscriptions = Reinscription::query()->where('classe_id', $validated['classe_id'])
                        ->where('annee_scolaire_id', $validated['annee_scolaire_id'])
                        ->where('statut', 'confirmee')
                        ->count();

                    // Facultatif : si on veut combiner les inscripts et reinscripts pour la capacité
                    // ...

                    $reinscription = Reinscription::create([
                        'eleve_id' => $eleve_id,
                        'classe_id' => $validated['classe_id'],
                        'annee_scolaire_id' => $validated['annee_scolaire_id'],
                        'date_reinscription' => $validated['date_inscription'],
                        'statut' => $validated['statut'] ? 'confirmee' : 'en_attente',
                        'observation' => $validated['observation'] ?? null,
                    ]);

                    return redirect()
                        ->route('admin.reinscriptions.index')
                        ->with('success', 'Réinscription effectuée avec succès.');
                }
            });
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
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
        $exists = Inscription::query()->where('eleve_id', $validated['eleve_id'])
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
        $classe = Classe::findOrFail($validated['classe_id']);
        $nbInscriptions = Inscription::query()->where('classe_id', $validated['classe_id'])
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
        /** @var Inscription $inscription */
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
    $dejaInscrit = Inscription::query()->where('eleve_id', $eleve_id)
        ->where('classe_id', $classe_id)
        ->where('annee_scolaire_id', $annee_scolaire_id)
        ->exists();

    // Vérifier les places disponibles
    $classe = Classe::findOrFail($classe_id);
    $nbInscriptions = Inscription::query()->where('classe_id', $classe_id)
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