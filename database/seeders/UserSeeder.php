<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Mot de passe par défaut pour tous les utilisateurs
     */
    private string $defaultPassword = 'password';

    /**
     * Liste des administrateurs par défaut
     */
    private array $admins = [
        [
            'name' => 'Admin Principal',
            'email' => 'admin@ecole.com',
            'password' => 'password',
            'is_active' => true,
        ],
        [
            'name' => 'Super Admin',
            'email' => 'super.admin@ecole.com',
            'password' => 'password',
            'is_active' => true,
        ],
    ];

    /**
     * Liste des enseignants (emails uniques avec domaine enseignant.com)
     */
    private array $enseignants = [
        ['name' => 'Jean Martin', 'email' => 'jean.martin@enseignant.com'],
        ['name' => 'Marie Bernard', 'email' => 'marie.bernard@enseignant.com'],
        ['name' => 'Pierre Dubois', 'email' => 'pierre.dubois@enseignant.com'],
        ['name' => 'Sophie Thomas', 'email' => 'sophie.thomas@enseignant.com'],
        ['name' => 'Philippe Petit', 'email' => 'philippe.petit@enseignant.com'],
    ];

    /**
     * Liste des élèves (emails uniques avec domaine eleve.com)
     */
    private array $eleves = [
        ['name' => 'Lucas Martin', 'email' => 'lucas.martin@eleve.com'],
        ['name' => 'Emma Bernard', 'email' => 'emma.bernard@eleve.com'],
        ['name' => 'Louis Dubois', 'email' => 'louis.dubois@eleve.com'],
        ['name' => 'Jade Thomas', 'email' => 'jade.thomas@eleve.com'],
        ['name' => 'Hugo Robert', 'email' => 'hugo.robert@eleve.com'],
    ];

    /**
     * Liste des parents (emails uniques avec domaine parent.com)
     */
    private array $parents = [
        ['name' => 'Jean Martin (père)', 'email' => 'jean.martin.parent@parent.com'],
        ['name' => 'Marie Martin (mère)', 'email' => 'marie.martin.parent@parent.com'],
        ['name' => 'Pierre Bernard', 'email' => 'pierre.bernard@parent.com'],
        ['name' => 'Sophie Dubois', 'email' => 'sophie.dubois@parent.com'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crypter le mot de passe par défaut
        $hashedPassword = Hash::make($this->defaultPassword);

        // Créer les rôles s'ils n'existent pas
        $this->creerRoles();

        $this->command->info('🔄 Création des utilisateurs...');

        $usersCrees = 0;
        $usersExistants = 0;

        // Créer les administrateurs
        foreach ($this->admins as $adminData) {
            $user = User::firstOrCreate(
                ['email' => $adminData['email']],
                [
                    'name' => $adminData['name'],
                    'password' => Hash::make($adminData['password']),
                    'is_active' => $adminData['is_active'],
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            if ($user->wasRecentlyCreated) {
                $user->assignRole('administrateur');
                $usersCrees++;
                $this->command->line("  ✅ Admin créé : {$adminData['name']} ({$adminData['email']})");
            } else {
                $usersExistants++;
                // S'assurer que le rôle admin est bien assigné
                if (!$user->hasRole('administrateur')) {
                    $user->assignRole('administrateur');
                    $this->command->line("  🔄 Rôle administrateur AJOUTÉ à : {$adminData['name']}");
                } else {
                    $this->command->line("  ℹ️ Admin existant : {$adminData['name']}");
                }
            }
        }

        // Créer les enseignants
        $resultatsEnseignants = $this->creerUtilisateursPourRole($this->enseignants, 'enseignant', $hashedPassword);
        $usersCrees += $resultatsEnseignants['crees'];
        $usersExistants += $resultatsEnseignants['existants'];

        // Créer les élèves
        $resultatsEleves = $this->creerUtilisateursPourRole($this->eleves, 'eleve', $hashedPassword);
        $usersCrees += $resultatsEleves['crees'];
        $usersExistants += $resultatsEleves['existants'];

        // Créer les parents
        $resultatsParents = $this->creerUtilisateursPourRole($this->parents, 'parent', $hashedPassword);
        $usersCrees += $resultatsParents['crees'];
        $usersExistants += $resultatsParents['existants'];

        // Créer des utilisateurs supplémentaires aléatoires
        $resultatsAleatoires = $this->creerUtilisateursAleatoires($hashedPassword);
        $usersCrees += $resultatsAleatoires['crees'];
        $usersExistants += $resultatsAleatoires['existants'];

        // Associer les utilisateurs aux profils existants
        $this->associerUtilisateursAuxProfils();

        // Vérification finale des rôles
        $this->verifierRoles();

        // Afficher le résumé
        $this->afficherResume($usersCrees, $usersExistants);
    }

    /**
     * Créer les rôles nécessaires
     */
    private function creerRoles(): void
    {
        $roles = ['administrateur', 'enseignant', 'eleve', 'parent'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        $this->command->info('✅ Rôles vérifiés/créés avec succès');
    }

    /**
     * Créer des utilisateurs pour un rôle spécifique
     */
    private function creerUtilisateursPourRole(array $usersData, string $role, string $hashedPassword): array
    {
        $crees = 0;
        $existants = 0;

        foreach ($usersData as $userData) {
            // Vérifier si l'utilisateur existe déjà par email
            $user = User::where('email', $userData['email'])->first();
            
            if (!$user) {
                // Créer l'utilisateur
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => $hashedPassword,
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                $user->assignRole($role);
                $crees++;
                $this->command->line("  ✅ {$role} créé : {$userData['name']} ({$userData['email']})");
            } else {
                $existants++;
                
                // FORCER l'assignation du rôle même si l'utilisateur existe
                if (!$user->hasRole($role)) {
                    $user->assignRole($role);
                    $this->command->line("  🔄 Rôle {$role} AJOUTÉ à : {$userData['name']} ({$userData['email']})");
                } else {
                    $this->command->line("  ℹ️ {$role} déjà présent : {$userData['name']} ({$userData['email']})");
                }
            }
        }

        return [
            'crees' => $crees,
            'existants' => $existants
        ];
    }

    /**
     * Créer des utilisateurs aléatoires
     */
    private function creerUtilisateursAleatoires(string $hashedPassword): array
    {
        $crees = 0;
        $existants = 0;
        $nombreAleatoires = 10;

        $this->command->line("  🔄 Création de {$nombreAleatoires} utilisateurs aléatoires...");

        for ($i = 0; $i < $nombreAleatoires; $i++) {
            $role = $this->getRoleAleatoire();
            $prenom = $this->getPrenomAleatoire();
            $nom = $this->getNomAleatoire();
            $name = $prenom . ' ' . $nom;
            $email = strtolower($prenom . '.' . $nom . rand(100, 999)) . '@exemple.com';

            $user = User::where('email', $email)->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'is_active' => rand(0, 100) <= 90,
                    'email_verified_at' => rand(0, 1) ? now() : null,
                    'created_at' => now()->subDays(rand(1, 365)),
                    'updated_at' => now(),
                ]);
                
                $user->assignRole($role);
                $crees++;
            } else {
                $existants++;
            }
        }

        $this->command->line("  ✅ {$crees} utilisateurs aléatoires créés, {$existants} existants");

        return [
            'crees' => $crees,
            'existants' => $existants
        ];
    }

    /**
     * Obtenir un rôle aléatoire
     */
    private function getRoleAleatoire(): string
    {
        $roles = ['enseignant', 'eleve', 'parent'];
        return $roles[array_rand($roles)];
    }

    /**
     * Obtenir un prénom aléatoire
     */
    private function getPrenomAleatoire(): string
    {
        $prenoms = ['Lucas', 'Emma', 'Louis', 'Jade', 'Hugo', 'Louise', 'Gabriel', 'Alice',
                   'Raphaël', 'Chloé', 'Jules', 'Léa', 'Adam', 'Manon', 'Arthur', 'Lina',
                   'Paul', 'Juliette', 'Alexandre', 'Sarah', 'Antoine', 'Camille'];
        return $prenoms[array_rand($prenoms)];
    }

    /**
     * Obtenir un nom aléatoire
     */
    private function getNomAleatoire(): string
    {
        $noms = ['Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Richard', 'Petit', 'Durand',
                'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'Michel', 'Garcia', 'David'];
        return $noms[array_rand($noms)];
    }

    /**
     * Associer les utilisateurs aux profils existants
     */
    private function associerUtilisateursAuxProfils(): void
    {
        $this->command->line("  🔄 Association des utilisateurs aux profils...");
        $associations = 0;

        // Vérifier que les modèles existent avant de les utiliser
        if (class_exists('\App\Models\Enseignant')) {
            $enseignants = \App\Models\Enseignant::whereNull('user_id')->get();
            foreach ($enseignants as $enseignant) {
                // Chercher par email d'abord, puis par nom
                $user = User::where('email', $enseignant->email)->first();
                
                if (!$user) {
                    $user = User::where('name', 'like', '%' . $enseignant->prenom . '%')
                        ->where('name', 'like', '%' . $enseignant->nom . '%')
                        ->first();
                }

                if ($user && !$user->enseignant) {
                    $enseignant->update(['user_id' => $user->id]);
                    $associations++;
                    $this->command->line("    ✅ Enseignant {$enseignant->nom_complet} associé à {$user->email}");
                }
            }
        }

        if (class_exists('\App\Models\Eleve')) {
            $eleves = \App\Models\Eleve::whereNull('user_id')->get();
            foreach ($eleves as $eleve) {
                // Chercher par email d'abord, puis par nom
                $user = User::where('email', $eleve->email)->first();
                
                if (!$user) {
                    $user = User::where('name', 'like', '%' . $eleve->prenom . '%')
                        ->where('name', 'like', '%' . $eleve->nom . '%')
                        ->first();
                }

                if ($user && !$user->eleve) {
                    $eleve->update(['user_id' => $user->id]);
                    $associations++;
                    $this->command->line("    ✅ Élève {$eleve->nom_complet} associé à {$user->email}");
                }
            }
        }

        if (class_exists('\App\Models\ParentEleve')) {
            $parents = \App\Models\ParentEleve::whereNull('user_id')->get();
            foreach ($parents as $parent) {
                // Chercher par email d'abord, puis par nom
                $user = User::where('email', $parent->email)->first();
                
                if (!$user) {
                    $user = User::where('name', 'like', '%' . $parent->prenom . '%')
                        ->where('name', 'like', '%' . $parent->nom . '%')
                        ->first();
                }

                if ($user && !$user->parentEleve) {
                    $parent->update(['user_id' => $user->id]);
                    $associations++;
                    $this->command->line("    ✅ Parent {$parent->full_name} associé à {$user->email}");
                }
            }
        }

        $this->command->line("  ✅ {$associations} associations réalisées");
    }

    /**
     * Vérifier que tous les rôles sont correctement assignés
     */
    private function verifierRoles(): void
    {
        $this->command->line("  🔍 Vérification des rôles...");
        
        $totalParRole = [
            'administrateur' => 0,
            'enseignant' => 0,
            'eleve' => 0,
            'parent' => 0,
        ];
        
        $users = User::with('roles')->get();
        foreach ($users as $user) {
            foreach ($user->roles as $role) {
                if (isset($totalParRole[$role->name])) {
                    $totalParRole[$role->name]++;
                }
            }
        }
        
        $this->command->line("  📊 Rôles dans la base de données :");
        foreach ($totalParRole as $role => $count) {
            $this->command->line("      - {$role}: {$count} utilisateur(s)");
        }
        
        // Vérification des écarts
        if ($totalParRole['administrateur'] < count($this->admins)) {
            $this->command->warn("  ⚠️ Attention: Moins d'administrateurs que prévu!");
        }
        if ($totalParRole['enseignant'] < count($this->enseignants)) {
            $this->command->warn("  ⚠️ Attention: Moins d'enseignants que prévu!");
        }
        if ($totalParRole['eleve'] < count($this->eleves)) {
            $this->command->warn("  ⚠️ Attention: Moins d'élèves que prévu!");
        }
        if ($totalParRole['parent'] < count($this->parents)) {
            $this->command->warn("  ⚠️ Attention: Moins de parents que prévu!");
        }
    }

    /**
     * Afficher un résumé des utilisateurs créés
     */
    private function afficherResume(int $usersCrees, int $usersExistants): void
    {
        $totalUsers = User::count();
        $usersActifs = User::where('is_active', true)->count();

        $statsParRole = [];
        foreach (['administrateur', 'enseignant', 'eleve', 'parent'] as $role) {
            $statsParRole[$role] = User::role($role)->count();
        }

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES UTILISATEURS');
        $this->command->info("Total utilisateurs : {$totalUsers}");
        $this->command->info("Utilisateurs créés maintenant : {$usersCrees}");
        $this->command->info("Utilisateurs existants : {$usersExistants}");
        $this->command->info("Utilisateurs actifs : {$usersActifs} (" . round(($usersActifs / max($totalUsers, 1)) * 100, 1) . "%)");
        $this->command->info('------------------------------------');

        $this->command->info('👥 Répartition par rôle :');
        foreach ($statsParRole as $role => $count) {
            $pourcentage = round(($count / max($totalUsers, 1)) * 100, 1);
            $icone = match($role) {
                'administrateur' => '👑',
                'enseignant' => '👨‍🏫',
                'eleve' => '👨‍🎓',
                'parent' => '👪',
                default => '👤',
            };
            $this->command->line("  {$icone} " . ucfirst($role) . "s : {$count} ({$pourcentage}%)");
        }

        $this->command->info('====================================');
        $this->command->info('✅ Seeder User exécuté avec succès !');
        $this->command->info('🔐 Tous les mots de passe sont cryptés (mot de passe par défaut : "password")');
        $this->command->info('📧 Emails uniques par domaine :');
        $this->command->line('    - Admin: @ecole.com');
        $this->command->line('    - Enseignant: @enseignant.com');
        $this->command->line('    - Élève: @eleve.com');
        $this->command->line('    - Parent: @parent.com');
    }
}