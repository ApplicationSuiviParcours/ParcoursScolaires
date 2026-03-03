<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParentEleve;
use App\Models\User;
use App\Models\Eleve;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ParentEleveSeeder extends Seeder
{
    /**
     * Liste des prénoms français
     */
    private array $prenoms = [
        'Jean', 'Marie', 'Pierre', 'Sophie', 'Philippe', 'Isabelle', 'Michel', 'Catherine',
        'Nicolas', 'Françoise', 'Christophe', 'Valérie', 'Patrick', 'Sylvie', 'Laurent', 'Anne',
        'Eric', 'Christine', 'David', 'Martine', 'Thierry', 'Nathalie', 'Daniel', 'Céline',
        'Pascal', 'Véronique', 'Bruno', 'Hélène', 'Olivier', 'Sandrine', 'Franck', 'Stéphanie',
        'Sébastien', 'Emmanuelle', 'Vincent', 'Karine', 'Jérôme', 'Delphine', 'Christian', 'Laurence',
        'Alain', 'Patricia', 'Didier', 'Brigitte', 'Gilles', 'Danielle', 'Frédéric', 'Monique'
    ];

    /**
     * Liste des noms de famille français
     */
    private array $noms = [
        'Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Richard', 'Petit', 'Durand',
        'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'Michel', 'Garcia', 'David',
        'Bertrand', 'Roux', 'Vincent', 'Fournier', 'Morel', 'Girard', 'Andre', 'Lefevre',
        'Mercier', 'Dupont', 'Lambert', 'Bonnet', 'Francois', 'Martinez', 'Legrand',
        'Garnier', 'Faure', 'Rousseau', 'Blanc', 'Guerin', 'Muller', 'Henry', 'Roussel',
        'Nicolas', 'Perrin', 'Morin', 'Mathieu', 'Clement', 'Gauthier', 'Dumont', 'Lopez'
    ];

    /**
     * Professions des parents
     */
    private array $professions = [
        'Enseignant', 'Médecin', 'Avocat', 'Ingénieur', 'Commerçant', 'Artisan',
        'Fonctionnaire', 'Infirmier', 'Cadre', 'Agent commercial', 'Architecte',
        'Comptable', 'Journaliste', 'Consultant', 'Entrepreneur', 'Sans emploi',
        'Retraité', 'Agent de sécurité', 'Chauffeur', 'Agriculteur', 'Directeur',
        'Secrétaire', 'Employé de banque', 'Développeur', 'Chef de projet'
    ];

    /**
     * Villes de naissance
     */
    private array $villes = [
        'Paris', 'Lyon', 'Marseille', 'Toulouse', 'Bordeaux', 'Lille', 'Strasbourg',
        'Nantes', 'Rennes', 'Grenoble', 'Montpellier', 'Nice', 'Dijon', 'Orléans',
        'Tours', 'Clermont-Ferrand', 'Le Havre', 'Saint-Étienne', 'Caen', 'Angers',
        'Nancy', 'Metz', 'Reims', 'Rouen', 'Brest', 'Limoges', 'Poitiers'
    ];

    /**
     * Notes internes possibles
     */
    private array $notesInternes = [
        'Parent disponible et impliqué',
        'Parent souvent absent aux réunions',
        'À contacter en priorité',
        'Famille nombreuse (réduction possible)',
        'Parent délégué de classe',
        'Membre de l\'association des parents d\'élèves',
        'Demande de communication par email uniquement',
        'Ne souhaite pas être dérangé pendant les heures de travail',
        'Disponible pour accompagner les sorties scolaires',
        'Difficultés financières (demande de bourse)',
        null,
        null,
        null,
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fr_FR');
        
        // Récupérer les élèves pour les associations
        $eleves = Eleve::all();

        if ($eleves->isEmpty()) {
            $this->command->warn('⚠️ Aucun élève trouvé. Les parents seront créés sans association.');
        }

        // Demander le nombre de parents à créer
        $nombreParents = $this->command->ask('Combien de parents voulez-vous créer ?', 30);
        
        $this->command->info("🔄 Création de {$nombreParents} parents d'élèves...");

        $parentsCrees = 0;
        $utilisateursCrees = 0;
        $associationsCrees = 0;

        for ($i = 0; $i < $nombreParents; $i++) {
            // Générer les données de base
            $genre = rand(0, 1) ? 'M' : 'F';
            $prenom = $this->getPrenomAleatoire($genre);
            $nom = $this->noms[array_rand($this->noms)];
            $email = strtolower($prenom . '.' . $nom . rand(1, 999)) . '@parent.fr';
            $dateNaissance = $this->genererDateNaissance();

            // Créer un utilisateur associé (50% des parents)
            $user = null;
            if (rand(0, 100) <= 50) {
                $user = User::create([
                    'name' => $prenom . ' ' . $nom,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $utilisateursCrees++;
            }

            // Vérifier l'unicité de l'email
            while (ParentEleve::where('email', $email)->exists()) {
                $email = strtolower($prenom . '.' . $nom . rand(1000, 9999)) . '@parent.fr';
            }

            // Créer le parent
            $parent = ParentEleve::create([
                'user_id' => $user?->id,
                'nom' => $nom,
                'prenom' => $prenom,
                'genre' => $genre,
                'profession' => $this->professions[array_rand($this->professions)],
                'telephone' => $this->genererTelephone(),
                'email' => $email,
                'adresse' => $this->genererAdresse(),
                'photo' => null,
                'date_naissance' => $dateNaissance,
                'lieu_naissance' => $this->villes[array_rand($this->villes)],
                'statut' => rand(0, 100) <= 90, // 90% actifs
                'notes' => $this->notesInternes[array_rand($this->notesInternes)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $parentsCrees++;

            // Associer le parent à des élèves (s'il y a des élèves)
            if ($eleves->isNotEmpty()) {
                $nombreEnfants = $this->determinerNombreEnfants($i);
                $elevesSelectionnes = $eleves->random(min($nombreEnfants, $eleves->count()));
                
                foreach ($elevesSelectionnes as $eleve) {
                    // Déterminer le lien parental
                    $lienParental = $this->determinerLienParental($genre, $eleve);
                    
                    // Vérifier si l'association existe déjà
                    $existe = DB::table('eleve_parents')
                        ->where('parent_eleve_id', $parent->id)
                        ->where('eleve_id', $eleve->id)
                        ->exists();

                    if (!$existe) {
                        DB::table('eleve_parents')->insert([
                            'parent_eleve_id' => $parent->id,
                            'eleve_id' => $eleve->id,
                            'lien_parental' => $lienParental,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $associationsCrees++;
                    }
                }
            }

            // Afficher la progression
            if (($i + 1) % 10 == 0) {
                $this->command->line("  ✅ {$i}/{$nombreParents} parents créés...");
            }
        }

        // Créer des parents supplémentaires pour les élèves sans parent
        $parentsSupplementaires = $this->creerParentsPourElevesSansParent($eleves);
        $parentsCrees += $parentsSupplementaires['parents'];
        $associationsCrees += $parentsSupplementaires['associations'];

        // Afficher le résumé
        $this->afficherResume($parentsCrees, $utilisateursCrees, $associationsCrees);
    }

    /**
     * Obtenir un prénom aléatoire selon le genre
     */
    private function getPrenomAleatoire(string $genre): string
    {
        $prenomsF = ['Marie', 'Sophie', 'Isabelle', 'Catherine', 'Françoise', 'Valérie', 'Sylvie', 'Anne', 'Christine', 'Martine', 'Nathalie', 'Céline', 'Véronique', 'Hélène', 'Sandrine', 'Stéphanie', 'Emmanuelle', 'Karine', 'Delphine', 'Laurence', 'Patricia', 'Brigitte', 'Danielle', 'Monique'];
        $prenomsM = ['Jean', 'Pierre', 'Philippe', 'Michel', 'Nicolas', 'Christophe', 'Patrick', 'Laurent', 'Eric', 'David', 'Thierry', 'Daniel', 'Pascal', 'Bruno', 'Olivier', 'Franck', 'Sébastien', 'Vincent', 'Jérôme', 'Christian', 'Alain', 'Didier', 'Gilles', 'Frédéric'];

        if ($genre === 'F') {
            return $prenomsF[array_rand($prenomsF)];
        } else {
            return $prenomsM[array_rand($prenomsM)];
        }
    }

    /**
     * Générer une date de naissance (entre 25 et 60 ans)
     */
    private function genererDateNaissance(): Carbon
    {
        $age = rand(25, 60);
        return Carbon::now()->subYears($age)->subDays(rand(1, 365));
    }

    /**
     * Générer un numéro de téléphone
     */
    private function genererTelephone(): string
    {
        return '0' . rand(6, 7) . rand(10, 99) . rand(10, 99) . rand(10, 99) . rand(10, 99);
    }

    /**
     * Générer une adresse
     */
    private function genererAdresse(): string
    {
        $faker = Faker::create('fr_FR');
        return rand(1, 150) . ' ' . $faker->streetName . ', ' . $faker->city . ' ' . rand(10000, 95999);
    }

    /**
     * Déterminer le nombre d'enfants pour un parent
     */
    private function determinerNombreEnfants(int $index): int
    {
        // Distribution réaliste
        $rand = rand(1, 100);
        
        if ($rand <= 10) { // 10% sans enfant (cas particulier)
            return 0;
        } elseif ($rand <= 40) { // 30% avec 1 enfant
            return 1;
        } elseif ($rand <= 75) { // 35% avec 2 enfants
            return 2;
        } elseif ($rand <= 95) { // 20% avec 3 enfants
            return 3;
        } else { // 5% avec 4 enfants ou plus
            return rand(4, 6);
        }
    }

    /**
     * Déterminer le lien parental
     */
    private function determinerLienParental(string $genreParent, $eleve): string
    {
        if ($genreParent === 'F') {
            return rand(0, 100) <= 80 ? 'mere' : 'tante';
        } else {
            return rand(0, 100) <= 80 ? 'pere' : 'oncle';
        }
    }

    /**
     * Créer des parents pour les élèves sans parent
     */
    private function creerParentsPourElevesSansParent($eleves): array
    {
        if ($eleves->isEmpty()) {
            return ['parents' => 0, 'associations' => 0];
        }

        $parentsCrees = 0;
        $associationsCrees = 0;

        // Récupérer les élèves sans parent
        $elevesAvecParent = DB::table('eleve_parents')->distinct('eleve_id')->pluck('eleve_id');
        $elevesSansParent = $eleves->whereNotIn('id', $elevesAvecParent);

        if ($elevesSansParent->isEmpty()) {
            return ['parents' => 0, 'associations' => 0];
        }

        $this->command->info("🔄 Création de parents pour " . $elevesSansParent->count() . " élèves sans parent...");

        // Grouper les élèves par nom de famille
        $elevesParNom = $elevesSansParent->groupBy('nom');

        foreach ($elevesParNom as $nom => $elevesFamille) {
            // Créer un ou deux parents pour cette famille
            $nombreParents = rand(1, 2);
            
            for ($i = 0; $i < $nombreParents; $i++) {
                $genre = $i == 0 ? 'M' : 'F';
                $prenom = $this->getPrenomAleatoire($genre);
                $email = strtolower($prenom . '.' . $nom) . '@famille.fr';
                
                // Vérifier si le parent existe déjà
                $parentExistant = ParentEleve::where('nom', $nom)
                    ->where('prenom', $prenom)
                    ->first();

                if ($parentExistant) {
                    $parent = $parentExistant;
                } else {
                    $parent = ParentEleve::create([
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'genre' => $genre,
                        'profession' => $this->professions[array_rand($this->professions)],
                        'telephone' => $this->genererTelephone(),
                        'email' => $email,
                        'adresse' => $this->genererAdresse(),
                        'date_naissance' => $this->genererDateNaissance(),
                        'lieu_naissance' => $this->villes[array_rand($this->villes)],
                        'statut' => true,
                        'notes' => 'Parent créé automatiquement',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $parentsCrees++;
                }

                // Associer à tous les enfants de la famille
                foreach ($elevesFamille as $eleve) {
                    $lien = $genre === 'F' ? 'mere' : 'pere';
                    
                    DB::table('eleve_parents')->insert([
                        'parent_eleve_id' => $parent->id,
                        'eleve_id' => $eleve->id,
                        'lien_parental' => $lien,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $associationsCrees++;
                }
            }
        }

        return ['parents' => $parentsCrees, 'associations' => $associationsCrees];
    }

    /**
     * Afficher un résumé des créations
     */
    private function afficherResume(int $parentsCrees, int $utilisateursCrees, int $associationsCrees): void
    {
        $totalParents = ParentEleve::count();
        $actifs = ParentEleve::where('statut', true)->count();
        
        $statsParGenre = ParentEleve::selectRaw('genre, count(*) as total')
            ->groupBy('genre')
            ->get();

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES PARENTS D\'ÉLÈVES');
        $this->command->info("Total parents : {$totalParents}");
        $this->command->info("Parents créés maintenant : {$parentsCrees}");
        $this->command->info("Comptes utilisateur créés : {$utilisateursCrees}");
        $this->command->info("Associations avec élèves : {$associationsCrees}");
        $this->command->info("Parents actifs : {$actifs} (" . round(($actifs / max($totalParents, 1)) * 100, 1) . "%)");
        $this->command->info('------------------------------------');
        
        $this->command->info('👤 Répartition par genre :');
        foreach ($statsParGenre as $stat) {
            $libelle = $stat->genre === 'M' ? 'Masculin' : 'Féminin';
            $pourcentage = round(($stat->total / $totalParents) * 100, 1);
            $this->command->line("  • {$libelle} : {$stat->total} ({$pourcentage}%)");
        }

        // Statistiques des associations
        $totalAssociations = DB::table('eleve_parents')->count();
        $enfantsAvecParent = DB::table('eleve_parents')->distinct('eleve_id')->count('eleve_id');
        $totalEleves = Eleve::count();

        $this->command->info('------------------------------------');
        $this->command->info('🔗 Statistiques des associations :');
        $this->command->line("  • Total associations : {$totalAssociations}");
        $this->command->line("  • Élèves avec parent(s) : {$enfantsAvecParent}/{$totalEleves} (" . round(($enfantsAvecParent / max($totalEleves, 1)) * 100, 1) . "%)");
        
        $this->command->info('====================================');
        $this->command->info('✅ Seeder ParentEleve exécuté avec succès !');
    }
}