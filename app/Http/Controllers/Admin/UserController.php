<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\ParentEleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $roleFilter = $request->get('role');
        $statusFilter = $request->get('status');

        $query = User::with(['roles', 'enseignant', 'eleve', 'parentEleve']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($roleFilter) {
            $query->role($roleFilter);
        }

        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $users = $query->orderBy('name')->paginate(15);

        // Statistiques
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();

        // Statistiques par rôle
        $adminUsers = User::role('administrateur')->count();
        $enseignantUsers = User::role('enseignant')->count();
        $eleveUsers = User::role('eleve')->count();
        $parentUsers = User::role('parent')->count();

        $stats = [
            'with_photo' => User::whereNotNull('photo')->count(),
            'without_photo' => User::whereNull('photo')->count(),
            'never_logged_in' => User::whereNull('last_login_at')->count(),
            'verified_emails' => User::whereNotNull('email_verified_at')->count(),
            'unverified_emails' => User::whereNull('email_verified_at')->count(),
            'recently_joined' => User::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        // Liste des rôles pour le filtre
        $roles = Role::all();

        return view('admin.users.index', compact(
            'users',
            'search',
            'roleFilter',
            'statusFilter',
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'adminUsers',
            'enseignantUsers',
            'eleveUsers',
            'parentUsers',
            'roles',
            'stats'
        ));
    }

    /**
     * Affiche le formulaire de création d'un utilisateur
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Enregistre un nouvel utilisateur
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Password::defaults()],
                'roles' => ['required', 'array', 'min:1'],
                'roles.*' => ['exists:roles,id'],
                'is_active' => ['sometimes', 'boolean'],
                'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                
                // Champs optionnels pour les profils
                'date_naissance' => ['nullable', 'date'],
                'lieu_naissance' => ['nullable', 'string', 'max:255'],
                'genre' => ['nullable', 'in:m,f'],
                'telephone' => ['nullable', 'string', 'max:20'],
                'adresse' => ['nullable', 'string', 'max:500'],
                'specialite' => ['nullable', 'string', 'max:255'],
                'profession' => ['nullable', 'string', 'max:255'],
            ]);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => $request->boolean('is_active', true),
            ];

            Log::info('Tentative de création utilisateur', $data);

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('users/photos', 'public');
                $data['photo'] = $path;
            }

            Log::info('Données finales:', $data);

            // Créer l'utilisateur
            $user = User::create($data);

            if (!$user) {
                throw new \Exception("Échec de la création de l'utilisateur");
            }

            Log::info('Utilisateur créé avec ID: ' . $user->id);

            // Assigner les rôles
            $roleIds = $request->roles;
            $user->roles()->sync($roleIds);
            
            // Récupérer les noms des rôles pour faciliter les vérifications
            $roleNames = Role::whereIn('id', $roleIds)->pluck('name')->toArray();
            
            Log::info('Rôles synchronisés', $roleNames);

            // ✅ CRÉATION AUTOMATIQUE DES PROFILS SELON LES RÔLES
            $this->createProfilesForUser($user, $roleNames, $request);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Utilisateur créé avec succès. ID: ' . $user->id);

        } catch (\Exception $e) {
            Log::error('Erreur création utilisateur: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Erreur: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Crée les profils pour l'utilisateur en fonction de ses rôles
     */
    private function createProfilesForUser($user, $roleNames, $request)
    {
        $nameParts = explode(' ', $user->name, 2);
        $prenom = $nameParts[0];
        $nom = $nameParts[1] ?? $nameParts[0];

        // Créer le profil élève si nécessaire
        if (in_array('eleve', $roleNames)) {
            $this->createEleveProfile($user, $nom, $prenom, $request);
        }

        // Créer le profil enseignant si nécessaire
        if (in_array('enseignant', $roleNames)) {
            $this->createEnseignantProfile($user, $nom, $prenom, $request);
        }

        // Créer le profil parent si nécessaire
        if (in_array('parent', $roleNames)) {
            $this->createParentProfile($user, $nom, $prenom, $request);
        }
    }

    /**
     * Créer le profil élève
     */
    private function createEleveProfile($user, $nom, $prenom, $request)
    {
        try {
            // Vérifier si un profil existe déjà
            if ($user->eleve()->exists()) {
                Log::warning('Un profil élève existe déjà pour l\'utilisateur ' . $user->id);
                return $user->eleve;
            }

            // Générer un matricule
            $matricule = Eleve::genererMatricule($nom);
            
            // Créer l'élève
            $eleve = Eleve::create([
                'user_id' => $user->id,
                'nom' => $nom,
                'prenom' => $prenom,
                'matricule' => $matricule,
                'email' => $user->email,
                'statut' => $user->is_active,
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance ?? '',
                'genre' => $request->genre ?? 'm',
                'adresse' => $request->adresse ?? '',
                'telephone' => $request->telephone ?? '',
                'date_inscription' => now(),
            ]);
            
            Log::info('Profil élève créé pour l\'utilisateur ' . $user->id . ' avec ID: ' . $eleve->id);
            
            return $eleve;
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du profil élève: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Créer le profil enseignant
     */
    private function createEnseignantProfile($user, $nom, $prenom, $request)
    {
        try {
            // Vérifier si un profil existe déjà
            if ($user->enseignant()->exists()) {
                Log::warning('Un profil enseignant existe déjà pour l\'utilisateur ' . $user->id);
                return $user->enseignant;
            }

            // Générer un matricule enseignant
            $matricule = 'ENS-' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
            
            $enseignant = Enseignant::create([
                'user_id' => $user->id,
                'nom' => $nom,
                'prenom' => $prenom,
                'matricule' => $matricule,
                'email' => $user->email,
                'statut' => $user->is_active,
                'specialite' => $request->specialite ?? '',
                'telephone' => $request->telephone ?? '',
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance ?? '',
                'genre' => $request->genre ?? 'm',
                'adresse' => $request->adresse ?? '',
            ]);
            
            Log::info('Profil enseignant créé pour l\'utilisateur ' . $user->id . ' avec ID: ' . $enseignant->id);
            
            return $enseignant;
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du profil enseignant: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Créer le profil parent
     */
    private function createParentProfile($user, $nom, $prenom, $request)
    {
        try {
            // Vérifier si un profil existe déjà
            if ($user->parentEleve()->exists()) {
                Log::warning('Un profil parent existe déjà pour l\'utilisateur ' . $user->id);
                return $user->parentEleve;
            }

            $parent = ParentEleve::create([
                'user_id' => $user->id,
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $user->email,
                'telephone' => $request->telephone ?? '',
                'adresse' => $request->adresse ?? '',
                'profession' => $request->profession ?? '',
            ]);
            
            Log::info('Profil parent créé pour l\'utilisateur ' . $user->id . ' avec ID: ' . $parent->id);
            
            return $parent;
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du profil parent: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Affiche les détails d'un utilisateur
     */
    public function show(User $user)
    {
        $user->load([
            'roles',
            'enseignant',
            'eleve',
            'parentEleve',
            'notifications'
        ]);

        $unreadNotificationsCount = $user->unreadNotifications()->count();

        return view('admin.users.show', compact('user', 'unreadNotificationsCount'));
    }

    /**
     * Affiche le formulaire d'édition d'un utilisateur
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();

        // ✅ Nécessaire pour la vue
        $adminCount = User::role('administrateur')->count();

        // ✅ Optionnel mais utile
        $hasEnseignant = $user->enseignant()->exists();
        $hasEleve = $user->eleve()->exists();
        $hasParent = $user->parentEleve()->exists();

        return view('admin.users.edit', compact(
            'user',
            'roles',
            'userRoles',
            'adminCount',
            'hasEnseignant',
            'hasEleve',
            'hasParent'
        ));
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,id'],
            'is_active' => ['sometimes', 'boolean'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'remove_photo' => ['sometimes', 'boolean'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->boolean('remove_photo') && $user->photo) {
            Storage::disk('public')->delete($user->photo);
            $data['photo'] = null;
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('users/photos', 'public');
            $data['photo'] = $path;
        }

        $user->update($data);
        
        // Récupérer les anciens rôles avant synchronisation
        $oldRoles = $user->roles->pluck('name')->toArray();
        
        // Synchroniser les rôles
        $user->roles()->sync($request->roles);
        
        // Récupérer les nouveaux rôles
        $newRoles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
        
        // Vérifier si des profils doivent être créés pour les nouveaux rôles
        $this->syncProfilesForUser($user, $oldRoles, $newRoles, $request);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Synchronise les profils en fonction des changements de rôles
     */
    private function syncProfilesForUser($user, $oldRoles, $newRoles, $request)
    {
        $nameParts = explode(' ', $user->name, 2);
        $prenom = $nameParts[0];
        $nom = $nameParts[1] ?? $nameParts[0];

        // Rôles à ajouter (présents dans newRoles mais pas dans oldRoles)
        $rolesToAdd = array_diff($newRoles, $oldRoles);
        
        foreach ($rolesToAdd as $role) {
            switch ($role) {
                case 'eleve':
                    $this->createEleveProfile($user, $nom, $prenom, $request);
                    break;
                case 'enseignant':
                    $this->createEnseignantProfile($user, $nom, $prenom, $request);
                    break;
                case 'parent':
                    $this->createParentProfile($user, $nom, $prenom, $request);
                    break;
            }
        }
        
        // Note: On ne supprime pas automatiquement les profils quand on retire un rôle
        // car on veut garder l'historique. C'est une décision métier à prendre.
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy(User $user)
    {
        try {
            // Supprimer la photo si elle existe
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            
            // Supprimer les profils associés (optionnel - dépend de votre logique métier)
            if ($user->eleve) {
                $user->eleve->delete();
                Log::info('Profil élève supprimé pour l\'utilisateur ' . $user->id);
            }
            
            if ($user->enseignant) {
                $user->enseignant->delete();
                Log::info('Profil enseignant supprimé pour l\'utilisateur ' . $user->id);
            }
            
            if ($user->parentEleve) {
                $user->parentEleve->delete();
                Log::info('Profil parent supprimé pour l\'utilisateur ' . $user->id);
            }
            
            $user->delete();
            
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Utilisateur et profils associés supprimés avec succès.');
                
        } catch (\Exception $e) {
            Log::error('Erreur suppression utilisateur: ' . $e->getMessage());
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    /**
     * Supprime uniquement la photo d'un utilisateur
     */
    public function deletePhoto(User $user)
    {
        try {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
                $user->update(['photo' => null]);
                return redirect()->back()->with('success', 'Photo supprimée avec succès.');
            }
            return redirect()->back()->with('error', 'Aucune photo à supprimer.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue.');
        }
    }

    /**
     * Active/Désactive un utilisateur
     */
    public function toggleStatus(User $user)
    {
        try {
            $newStatus = !$user->is_active;
            $user->update(['is_active' => $newStatus]);
            
            // Mettre à jour le statut des profils associés
            if ($user->eleve) {
                $user->eleve->update(['statut' => $newStatus]);
            }
            if ($user->enseignant) {
                $user->enseignant->update(['statut' => $newStatus]);
            }
            
            $message = $newStatus ? 'Utilisateur activé.' : 'Utilisateur désactivé.';
            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue.');
        }
    }

    /**
     * Active un utilisateur
     */
    public function activate(User $user)
    {
        if ($user->is_active) {
            return redirect()->back()->with('info', 'L\'utilisateur est déjà actif.');
        }
        
        $user->update(['is_active' => true]);
        
        // Activer les profils associés
        if ($user->eleve) {
            $user->eleve->update(['statut' => true]);
        }
        if ($user->enseignant) {
            $user->enseignant->update(['statut' => true]);
        }
        
        return redirect()->back()->with('success', 'Utilisateur activé avec succès.');
    }

    /**
     * Désactive un utilisateur
     */
    public function deactivate(User $user)
    {
        if (!$user->is_active) {
            return redirect()->back()->with('info', 'L\'utilisateur est déjà inactif.');
        }
        
        $user->update(['is_active' => false]);
        
        // Désactiver les profils associés
        if ($user->eleve) {
            $user->eleve->update(['statut' => false]);
        }
        if ($user->enseignant) {
            $user->enseignant->update(['statut' => false]);
        }
        
        return redirect()->back()->with('success', 'Utilisateur désactivé avec succès.');
    }

    /**
     * Renvoie l'email de vérification
     */
    public function resendVerification(User $user)
    {
        if ($user->email_verified_at) {
            return redirect()->back()->with('info', 'L\'email est déjà vérifié.');
        }
        $user->sendEmailVerificationNotification();
        return redirect()->back()->with('success', 'Email de vérification renvoyé.');
    }

    /**
     * Recherche rapide d'utilisateurs
     */
    public function quickSearch(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $users = User::with('roles')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->roles->pluck('name'),
                    'is_active' => $user->is_active,
                    'has_eleve' => $user->eleve ? true : false,
                    'has_enseignant' => $user->enseignant ? true : false,
                    'has_parent' => $user->parentEleve ? true : false,
                ];
            });

        return response()->json($users);
    }

    /**
     * Affiche les notifications d'un utilisateur
     */
    public function notifications(User $user)
    {
        $notifications = $user->notifications()->latest()->paginate(20);
        return view('admin.users.notifications', compact('user', 'notifications'));
    }

    /**
     * Marque toutes les notifications comme lues
     */
    public function markAllNotificationsAsRead(User $user)
    {
        $user->unreadNotifications()->update(['read_at' => now()]);
        return redirect()->back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * Statistiques des utilisateurs
     */
    public function statistics()
    {
        return response()->json([
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'with_photo' => User::whereNotNull('photo')->count(),
            'verified_emails' => User::whereNotNull('email_verified_at')->count(),
            'with_eleve_profile' => User::has('eleve')->count(),
            'with_enseignant_profile' => User::has('enseignant')->count(),
            'with_parent_profile' => User::has('parentEleve')->count(),
        ]);
    }

    /**
     * Exporte la liste des utilisateurs
     */
    public function export()
    {
        $users = User::with('roles', 'eleve', 'enseignant', 'parentEleve')
            ->orderBy('name')
            ->get()
            ->map(function ($user) {
                $profileType = null;
                if ($user->eleve) $profileType = 'Élève';
                elseif ($user->enseignant) $profileType = 'Enseignant';
                elseif ($user->parentEleve) $profileType = 'Parent';
                
                return [
                    'ID' => $user->id,
                    'Nom' => $user->name,
                    'Email' => $user->email,
                    'Rôles' => $user->roles->pluck('name')->implode(', '),
                    'Type de profil' => $profileType ?? 'Aucun',
                    'Statut' => $user->is_active ? 'Actif' : 'Inactif',
                    'Email vérifié' => $user->email_verified_at ? 'Oui' : 'Non',
                    'Date création' => date('d/m/Y', strtotime($user->created_at)),
                ];
            });

        return response()->json($users);
    }
}