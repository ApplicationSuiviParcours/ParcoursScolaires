<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Inscription;
use App\Models\ParentEleve;
use App\Models\Note;
use App\Models\Absence;
use App\Models\Bulletin;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ElevesExport;

class EleveAdminController extends Controller
{
    /**
     * Affiche la liste des élèves
     */
    public function index(Request $request)
    {
        $query = Eleve::with([
            'inscriptions' => function($q) {
                $q->with('classe.anneeScolaire')->latest();
            },
            'parents'
        ]);

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhere('lieu_naissance', 'like', "%{$search}%")
                  ->orWhere('adresse', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        // Filtre par classe
        if ($request->filled('classe_id')) {
            $query->whereHas('inscriptions', function($q) use ($request) {
                $q->where('classe_id', $request->classe_id);
            });
        }

        // Filtre par année scolaire
        if ($request->filled('annee_scolaire_id')) {
            $query->whereHas('inscriptions', function($q) use ($request) {
                $q->where('annee_scolaire_id', $request->annee_scolaire_id);
            });
        }

        // Statistiques
        $stats = [
            'total' => Eleve::count(),
            'actifs' => Eleve::where('statut', true)->count(),
            'inactifs' => Eleve::where('statut', false)->count(),
            'garcons' => Eleve::where('genre', 'm')->count(),
            'filles' => Eleve::where('genre', 'f')->count(),
            'avec_compte' => Eleve::whereNotNull('user_id')->count(),
            'sans_compte' => Eleve::whereNull('user_id')->count(),
        ];

        // Pagination
        $eleves = $query->orderBy('nom')
            ->orderBy('prenom')
            ->paginate(15)
            ->withQueryString();

        // Récupérer toutes les classes
        $classes = Classe::with('anneeScolaire')->get();
        $anneesScolaires = AnneeScolaire::orderBy('nom', 'desc')->get();

        return view('admin.eleves.index', compact('eleves', 'stats', 'classes', 'anneesScolaires'));
    }

    /**
     * Show the form for creating a new eleve.
     */
    public function create()
    {
        // Récupérer l'année en cours
        $anneeActuelle = date('Y');

        // Récupérer le dernier élève créé dans l'année pour générer le numéro
        $dernierEleve = Eleve::whereYear('created_at', $anneeActuelle)->latest()->first();

        if ($dernierEleve && $dernierEleve->matricule) {
            // Extraire le numéro du dernier matricule (format: 2025D0123)
            $dernierNumero = intval(substr($dernierEleve->matricule, -4));
            $nouveauNumero = str_pad($dernierNumero + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nouveauNumero = '0001';
        }

        // La lettre sera définie plus tard dans le store, mais on prépare le numéro
        $matricule_genere = $anneeActuelle . '[Lettre]' . $nouveauNumero;

        // Récupérer les classes disponibles
        $classes = Classe::with('anneeScolaire')->get();

        // Récupérer l'année scolaire active
        $anneeScolaireActive = AnneeScolaire::where('active', true)->first();
        if (!$anneeScolaireActive) {
            $anneeScolaireActive = AnneeScolaire::first();
        }

        return view('admin.eleves.create', compact('matricule_genere', 'classes', 'anneeScolaireActive'));
    }

    /**
     * Store a newly created eleve in storage.
     */
    public function store(Request $request)
    {
        // ✅ CORRECTION: Ajout de 'classe_inscription_id' dans la validation
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'genre' => 'required|in:m,f',
            'adresse' => 'required|string',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:eleves,email',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'classe_inscription_id' => 'nullable|exists:classes,id', // ✅ AJOUTÉ
            'create_user' => 'nullable|boolean',
            'password' => 'nullable|required_if:create_user,1|string|min:6|confirmed',
        ], [
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'date_naissance.required' => 'La date de naissance est obligatoire',
            'lieu_naissance.required' => 'Le lieu de naissance est obligatoire',
            'genre.required' => 'Le genre est obligatoire',
            'adresse.required' => 'L\'adresse est obligatoire',
            'email.email' => 'L\'email doit être une adresse valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'photo.image' => 'Le fichier doit être une image',
            'photo.mimes' => 'L\'image doit être au format jpeg, png, jpg ou gif',
            'photo.max' => 'L\'image ne doit pas dépasser 2 Mo',
            'classe_inscription_id.exists' => 'La classe sélectionnée n\'existe pas',
            'password.required_if' => 'Le mot de passe est obligatoire pour créer un compte utilisateur',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->except('photo', 'create_user', 'password', 'password_confirmation', 'classe_inscription_id');
            $data['date_inscription'] = now();
            $data['statut'] = true;

            // ✅ CORRECTION: Génération correcte du matricule
            $anneeActuelle = date('Y');
            $premiereLettreNom = strtoupper(substr(trim($request->nom), 0, 1));

            // Vérifier que la première lettre est valide (A-Z)
            if (!preg_match('/[A-Z]/', $premiereLettreNom)) {
                $premiereLettreNom = 'X'; // Lettre par défaut
            }

            // Générer le numéro séquentiel
            $dernierEleve = Eleve::whereYear('created_at', $anneeActuelle)
                ->where('matricule', 'like', $anneeActuelle . '%')
                ->orderBy('matricule', 'desc')
                ->first();

            if ($dernierEleve && $dernierEleve->matricule) {
                $dernierNumero = intval(substr($dernierEleve->matricule, -4));
                $nouveauNumero = str_pad($dernierNumero + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $nouveauNumero = '0001';
            }

            // Générer le matricule au format: ANNÉE + LETTRE + NUMÉRO
            $data['matricule'] = $anneeActuelle . $premiereLettreNom . $nouveauNumero;

            // Vérifier l'unicité du matricule
            $tentatives = 0;
            while (Eleve::where('matricule', $data['matricule'])->exists() && $tentatives < 100) {
                $nouveauNumero = str_pad(intval($nouveauNumero) + 1, 4, '0', STR_PAD_LEFT);
                $data['matricule'] = $anneeActuelle . $premiereLettreNom . $nouveauNumero;
                $tentatives++;
            }

            // Gestion de l'upload de photo
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('photos/eleves', 'public');
                $data['photo'] = $path;
            }

            // Création de l'élève
            $eleve = Eleve::create($data);

            // ✅ AJOUT: Création d'une inscription si une classe est sélectionnée
            if ($request->filled('classe_inscription_id')) {
                $anneeScolaire = AnneeScolaire::where('active', true)->first();
                if (!$anneeScolaire) {
                    $anneeScolaire = AnneeScolaire::first();
                }

                if ($anneeScolaire) {
                    Inscription::create([
                        'eleve_id' => $eleve->id,
                        'classe_id' => $request->classe_inscription_id,
                        'annee_scolaire_id' => $anneeScolaire->id,
                        'date_inscription' => now(),
                        'statut' => true,
                        'observation' => 'Inscription initiale',
                    ]);
                }
            }

            // Création d'un compte utilisateur si demandé
            if ($request->filled('create_user') && $request->create_user) {
                // Générer l'email ou utiliser celui de l'élève
                $email = $eleve->email ?? $eleve->matricule . '@eleve.local';

                // Vérifier si l'email existe déjà dans la table users
                if (User::where('email', $email)->exists()) {
                    // Utiliser un email alternatif avec un suffixe numérique
                    $counter = 1;
                    $baseEmail = $eleve->matricule . '@eleve.local';
                    while (User::where('email', $baseEmail)->exists()) {
                        $baseEmail = $eleve->matricule . $counter . '@eleve.local';
                        $counter++;
                    }
                    $email = $baseEmail;
                }

                $user = User::create([
                    'name' => $eleve->prenom . ' ' . $eleve->nom,
                    'email' => $email,
                    'password' => Hash::make($request->password),
                    'role' => 'eleve',
                ]);

                $eleve->user_id = $user->id;
                $eleve->save();
            }

            DB::commit();

            return redirect()->route('admin.eleves.show', $eleve)
                ->with('success', 'Élève créé avec succès. Matricule : ' . $eleve->matricule);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la création : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified eleve.
     */
    public function show(Eleve $eleve)
    {
        $eleve->load([
            'inscriptions' => function($q) {
                $q->with(['classe.anneeScolaire'])->latest();
            },
            'parents',
            'absences' => function($q) {
                $q->with(['matiere', 'anneeScolaire'])->latest()->take(10);
            },
            'notes' => function($q) {
                $q->with(['evaluation.matiere', 'evaluation.classe'])->latest()->take(20);
            },
            'bulletins' => function($q) {
                $q->with(['classe', 'anneeScolaire'])->latest();
            },
            'user',
        ]);

        // Statistiques de l'élève
        $stats = [
            'moyenne_generale' => $eleve->notes()->avg('note'),
            'total_absences' => $eleve->absences()->count(),
            'absences_justifiees' => $eleve->absences()->where('justifiee', true)->count(),
            'absences_non_justifiees' => $eleve->absences()->where('justifiee', false)->count(),
            'inscriptions_count' => $eleve->inscriptions()->count(),
            'parents_count' => $eleve->parents()->count(),
            'bulletins_count' => $eleve->bulletins()->count(),
            'notes_count' => $eleve->notes()->count(),
        ];

        // Récupérer la classe actuelle via la dernière inscription active
        $inscriptionActive = $eleve->inscriptions()->where('statut', true)->with('classe')->latest()->first();
        $classeActuelle = $inscriptionActive?->classe;

        return view('admin.eleves.show', compact('eleve', 'stats', 'classeActuelle'));
    }

    /**
     * Show the form for editing the specified eleve.
     */
    public function edit(Eleve $eleve)
    {
        // Charger les inscriptions
        $eleve->load(['inscriptions' => function($q) {
            $q->with('classe')->latest();
        }]);

        $classes = Classe::with('anneeScolaire')->get();
        $anneeScolaireActive = AnneeScolaire::where('active', true)->first();
        if (!$anneeScolaireActive) {
            $anneeScolaireActive = AnneeScolaire::first();
        }

        return view('admin.eleves.edit', compact('eleve', 'classes', 'anneeScolaireActive'));
    }

    /**
     * Update the specified eleve in storage.
     */
    public function update(Request $request, Eleve $eleve)
    {
        // ✅ CORRECTION: Ajout de 'nouvelle_classe_id' dans la validation
        $request->validate([
            'matricule' => 'required|string|unique:eleves,matricule,' . $eleve->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'genre' => 'required|in:m,f',
            'adresse' => 'required|string',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:eleves,email,' . $eleve->id,
            'statut' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nouvelle_classe_id' => 'nullable|exists:classes,id', // ✅ AJOUTÉ
            'update_user' => 'nullable|boolean',
            'password' => 'nullable|required_if:update_user,1|string|min:6|confirmed',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->except('photo', 'update_user', 'password', 'password_confirmation', 'nouvelle_classe_id');

            // Gestion de l'upload de photo
            if ($request->hasFile('photo')) {
                if ($eleve->photo) {
                    Storage::disk('public')->delete($eleve->photo);
                }
                $path = $request->file('photo')->store('photos/eleves', 'public');
                $data['photo'] = $path;
            }

            // Mise à jour de l'élève
            $eleve->update($data);

            // ✅ AJOUT: Création d'une nouvelle inscription si demandé
            if ($request->filled('nouvelle_classe_id')) {
                // Désactiver l'ancienne inscription active
                Inscription::where('eleve_id', $eleve->id)
                    ->where('statut', true)
                    ->update(['statut' => false]);

                // Créer la nouvelle inscription
                $anneeScolaire = AnneeScolaire::where('active', true)->first();
                if (!$anneeScolaire) {
                    $anneeScolaire = AnneeScolaire::first();
                }

                Inscription::create([
                    'eleve_id' => $eleve->id,
                    'classe_id' => $request->nouvelle_classe_id,
                    'annee_scolaire_id' => $anneeScolaire->id,
                    'date_inscription' => now(),
                    'statut' => true,
                    'observation' => 'Changement de classe',
                ]);
            }

            // Mise à jour du compte utilisateur si demandé
            if ($request->filled('update_user') && $request->update_user && $eleve->user) {
                if ($request->filled('password')) {
                    $eleve->user->password = Hash::make($request->password);
                }
                if ($eleve->email && $eleve->email !== $eleve->user->email) {
                    // Check if email already exists for another user
                    $existingUser = User::where('email', $eleve->email)
                        ->where('id', '!=', $eleve->user->id)
                        ->first();

                    if ($existingUser) {
                        // Keep the old email instead of blocking the update
                        session()->flash('warning', 'L\'email n\'a pas été modifié car il est déjà utilisé par un autre utilisateur.');
                    } else {
                        $eleve->user->email = $eleve->email;
                    }
                }
                $eleve->user->name = $eleve->prenom . ' ' . $eleve->nom;
                
                // FIX: Utiliser save() avec vérification d'erreur pour éviter le duplicate
                try {
                    $eleve->user->save();
                } catch (\Illuminate\Database\QueryException $e) {
                    // Si erreur de duplicate email, restaurer l'ancien email
                    if ($e->errorInfo[1] == 1062) { // Code erreur MySQL pour duplicate entry
                        session()->flash('warning', 'L\'email n\'a pas été modifié car il est déjà utilisé par un autre utilisateur.');
                    } else {
                        throw $e;
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.eleves.show', $eleve)
                ->with('success', 'Élève mis à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified eleve from storage.
     */
    public function destroy(Eleve $eleve)
    {
        DB::beginTransaction();

        try {
            // Supprimer d'abord les inscriptions
            $eleve->inscriptions()->delete();

            // Détacher les parents
            $eleve->parents()->detach();

            // Supprimer l'utilisateur associé si existe
            if ($eleve->user) {
                $eleve->user->delete();
            }

            // Supprimer la photo si elle existe
            if ($eleve->photo) {
                Storage::disk('public')->delete($eleve->photo);
            }

            // Enfin, supprimer l'élève
            $eleve->delete();

            DB::commit();

            return redirect()->route('admin.eleves.index')
                ->with('success', 'Élève et ses inscriptions supprimés avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.eleves.index')
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    /**
     * Exporte la liste des élèves en Excel/CSV
     */
    public function export(Request $request)
    {
        $query = Eleve::with(['inscriptions.classe', 'parents', 'user']);

        // Appliquer les filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        if ($request->filled('classe_id')) {
            $query->whereHas('inscriptions', function($q) use ($request) {
                $q->where('classe_id', $request->classe_id);
            });
        }

        $eleves = $query->orderBy('nom')->orderBy('prenom')->get();

        // Génération du CSV
        $filename = 'eleves_' . date('Y-m-d_His') . '.csv';
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // En-têtes CSV
        fputcsv($handle, [
            'ID',
            'Matricule',
            'Nom',
            'Prénom',
            'Email',
            'Téléphone',
            'Date naissance',
            'Lieu naissance',
            'Âge',
            'Genre',
            'Adresse',
            'Classe actuelle',
            'Année scolaire',
            'Date inscription',
            'Statut',
            'Compte utilisateur',
            'Nombre de parents',
            'Nombre d\'inscriptions',
            'Moyenne générale',
            'Total absences',
            'Absences justifiées',
            'Absences non justifiées',
            'Créé le',
            'Dernière mise à jour'
        ]);

        foreach ($eleves as $eleve) {
            $inscriptionActive = $eleve->inscriptions()->where('statut', true)->with('classe.anneeScolaire')->first();
            $classeActuelle = $inscriptionActive?->classe->nom ?? 'Non inscrit';
            $anneeScolaire = $inscriptionActive?->classe?->anneeScolaire?->nom ?? 'N/A';
            $age = $eleve->date_naissance->age . ' ans';
            $moyenne = $eleve->notes()->avg('note');
            $moyenneFormatted = $moyenne ? number_format($moyenne, 2) . '/20' : 'N/A';

            fputcsv($handle, [
                $eleve->id,
                $eleve->matricule,
                $eleve->nom,
                $eleve->prenom,
                $eleve->email ?? 'Non renseigné',
                $eleve->telephone ?? 'Non renseigné',
                $eleve->date_naissance->format('d/m/Y'),
                $eleve->lieu_naissance,
                $age,
                $eleve->genre === 'm' ? 'Masculin' : 'Féminin',
                $eleve->adresse,
                $classeActuelle,
                $anneeScolaire,
                $eleve->date_inscription->format('d/m/Y'),
                $eleve->statut ? 'Actif' : 'Inactif',
                $eleve->user ? 'Oui' : 'Non',
                $eleve->parents()->count(),
                $eleve->inscriptions()->count(),
                $moyenneFormatted,
                $eleve->absences()->count(),
                $eleve->absences()->where('justifiee', true)->count(),
                $eleve->absences()->where('justifiee', false)->count(),
                $eleve->created_at->format('d/m/Y H:i'),
                $eleve->updated_at->format('d/m/Y H:i')
            ]);
        }

        fclose($handle);
        exit;
    }

    /**
     * Change le statut d'un élève (actif/inactif)
     */
    public function toggleStatut(Eleve $eleve)
    {
        $eleve->statut = !$eleve->statut;
        $eleve->save();

        return redirect()->back()
            ->with('success', 'Statut de l\'élève modifié avec succès.');
    }

    /**
     * Crée un compte utilisateur pour un élève
     */
    public function createUser(Eleve $eleve, Request $request)
    {
        if ($eleve->user) {
            return redirect()->back()
                ->with('error', 'Cet élève a déjà un compte utilisateur.');
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            // Générer l'email ou utiliser celui de l'élève
            $email = $eleve->email ?? $eleve->matricule . '@eleve.local';

            // Vérifier si l'email existe déjà dans la table users
            if (User::where('email', $email)->exists()) {
                // Utiliser un email alternatif avec un suffixe numérique
                $counter = 1;
                $baseEmail = $eleve->matricule . '@eleve.local';
                while (User::where('email', $baseEmail)->exists()) {
                    $baseEmail = $eleve->matricule . $counter . '@eleve.local';
                    $counter++;
                }
                $email = $baseEmail;
            }

            $user = User::create([
                'name' => $eleve->prenom . ' ' . $eleve->nom,
                'email' => $email,
                'password' => Hash::make($request->password),
                'role' => 'eleve',
            ]);

            $eleve->user_id = $user->id;
            $eleve->save();

            return redirect()->back()
                ->with('success', 'Compte utilisateur créé avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la création du compte : ' . $e->getMessage());
        }
    }

    /**
     * Réinitialise le mot de passe d'un élève
     */
    public function resetPassword(Eleve $eleve, Request $request)
    {
        if (!$eleve->user) {
            return redirect()->back()
                ->with('error', 'Cet élève n\'a pas de compte utilisateur.');
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $eleve->user->password = Hash::make($request->password);
            $eleve->user->save();

            return redirect()->back()
                ->with('success', 'Mot de passe réinitialisé avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la réinitialisation : ' . $e->getMessage());
        }
    }

    /**
     * Supprime le compte utilisateur d'un élève
     */
    public function deleteUser(Eleve $eleve)
    {
        if (!$eleve->user) {
            return redirect()->back()
                ->with('error', 'Cet élève n\'a pas de compte utilisateur.');
        }

        try {
            $eleve->user->delete();
            $eleve->user_id = null;
            $eleve->save();

            return redirect()->back()
                ->with('success', 'Compte utilisateur supprimé avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    /**
     * Affiche le calendrier des absences d'un élève
     */
    public function calendrierAbsences(Eleve $eleve, Request $request)
    {
        $mois = $request->get('mois', now()->month);
        $annee = $request->get('annee', now()->year);

        $absences = $eleve->absences()
            ->with('matiere')
            ->whereYear('date_absence', $annee)
            ->whereMonth('date_absence', $mois)
            ->orderBy('date_absence')
            ->get();

        return view('admin.eleves.calendrier-absences', compact('eleve', 'absences', 'mois', 'annee'));
    }

    /**
     * Affiche le relevé de notes d'un élève
     */
    public function releveNotes(Eleve $eleve, Request $request)
    {
        $periode = $request->get('periode', 'trimestre1');

        $notes = $eleve->notes()
            ->with(['evaluation.matiere', 'evaluation.classe'])
            ->whereHas('evaluation', function($q) use ($periode) {
                $q->where('periode', $periode);
            })
            ->get();

        $moyenne = $notes->avg('note');

        return view('admin.eleves.releve-notes', compact('eleve', 'notes', 'moyenne', 'periode'));
    }

    // ============ MÉTHODES D'EXPORT PDF ============

    /**
     * Exporter tous les élèves au format PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            $query = Eleve::with(['inscriptions.classe', 'parents', 'user']);

            // Appliquer les filtres
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%")
                      ->orWhere('prenom', 'like', "%{$search}%")
                      ->orWhere('matricule', 'like', "%{$search}%")
                      ->orWhere('telephone', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            if ($request->filled('statut')) {
                $query->where('statut', $request->statut);
            }

            if ($request->filled('genre')) {
                $query->where('genre', $request->genre);
            }

            if ($request->filled('classe_id')) {
                $query->whereHas('inscriptions', function($q) use ($request) {
                    $q->where('classe_id', $request->classe_id);
                });
            }

            $eleves = $query->orderBy('nom')->orderBy('prenom')->get();

            // Statistiques
            $stats = [
                'total' => $eleves->count(),
                'actifs' => $eleves->where('statut', true)->count(),
                'inactifs' => $eleves->where('statut', false)->count(),
                'garcons' => $eleves->where('genre', 'm')->count(),
                'filles' => $eleves->where('genre', 'f')->count(),
                'avec_compte' => $eleves->whereNotNull('user_id')->count(),
                'sans_compte' => $eleves->whereNull('user_id')->count(),
            ];

            $pdf = Pdf::loadView('admin.eleves.exports.pdf', compact('eleves', 'stats'));

            $filename = 'eleves_' . date('Y-m-d') . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'export PDF : ' . $e->getMessage());
        }
    }

    /**
     * Exporter tous les élèves au format Excel (via Maatwebsite)
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new ElevesExport($request), 'eleves_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Exporter le profil d'un élève spécifique au format PDF
     */
    public function exportProfilPdf(Eleve $eleve)
    {
        $eleve->load([
            'inscriptions' => function($q) {
                $q->with(['classe.anneeScolaire'])->latest();
            },
            'parents',
            'absences' => function($q) {
                $q->with(['matiere', 'anneeScolaire'])->latest();
            },
            'notes' => function($q) {
                $q->with(['evaluation.matiere', 'evaluation.classe'])->latest();
            },
            'bulletins' => function($q) {
                $q->with(['classe'])->latest();
            },
            'user',
        ]);

        // Récupérer la classe actuelle
        $inscriptionActive = $eleve->inscriptions()->where('statut', true)->with('classe')->first();
        $classeActuelle = $inscriptionActive?->classe;

        // Statistiques de l'élève
        $stats = [
            'moyenne_generale' => $eleve->notes()->avg('note'),
            'total_absences' => $eleve->absences()->count(),
            'absences_justifiees' => $eleve->absences()->where('justifiee', true)->count(),
            'absences_non_justifiees' => $eleve->absences()->where('justifiee', false)->count(),
            'inscriptions_count' => $eleve->inscriptions()->count(),
            'parents_count' => $eleve->parents()->count(),
            'bulletins_count' => $eleve->bulletins()->count(),
            'notes_count' => $eleve->notes()->count(),
            'age' => $eleve->date_naissance->age,
        ];

        $pdf = Pdf::loadView('admin.eleves.exports.profil-pdf', compact('eleve', 'stats', 'classeActuelle'));

        $filename = 'profil_' . $eleve->nom . '_' . $eleve->prenom . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Exporter le relevé de notes d'un élève au format PDF
     */
    public function exportReleveNotesPdf(Eleve $eleve, Request $request)
    {
        $periode = $request->get('periode', 'trimestre1');

        $notes = $eleve->notes()
            ->with(['evaluation.matiere', 'evaluation.classe'])
            ->whereHas('evaluation', function($q) use ($periode) {
                $q->where('periode', $periode);
            })
            ->get();

        $moyenne = $notes->avg('note');

        $stats = [
            'moyenne' => $moyenne,
            'total_notes' => $notes->count(),
            'periode' => $periode,
        ];

        $pdf = Pdf::loadView('admin.eleves.exports.releve-notes-pdf', compact('eleve', 'notes', 'stats'));

        $filename = 'releve_notes_' . $eleve->nom . '_' . $eleve->prenom . '_' . $periode . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
