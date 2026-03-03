<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class EnseignantSeeder extends Seeder
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
     * Spécialités d'enseignement
     */
    private array $specialites = [
        'Mathématiques',
        'Physique-Chimie',
        'Sciences de la Vie et de la Terre',
        'Français',
        'Histoire-Géographie',
        'Philosophie',
        'Anglais',
        'Espagnol',
        'Allemand',
        'Italien',
        'Latin',
        'Grec ancien',
        'Éducation Physique et Sportive',
        'Arts Plastiques',
        'Musique',
        'Technologie',
        'Sciences Économiques et Sociales',
        'Sciences de l\'Ingénieur',
        'Numérique et Sciences Informatiques',
        'Biotechnologies',
        'Gestion',
        'Marketing',
        'Économie',
        'Droit',
    ];

    /**
     * Villes de naissance
     */
    private array $villes = [
        'Paris', 'Lyon', 'Marseille', 'Toulouse', 'Bordeaux', 'Lille', 'Strasbourg',
        'Nantes', 'Rennes', 'Grenoble', 'Montpellier', 'Nice', 'Dijon', 'Orléans',
        'Tours', 'Clermont-Ferrand', 'Le Havre', 'Saint-Étienne', 'Caen', 'Angers',
        'Nancy', 'Metz', 'Reims', 'Rouen', 'Brest', 'Limoges', 'Poitiers', 'Besançon'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        // Demander le nombre d'enseignants à créer
        $nombreEnseignants = $this->command->ask('Combien d\'enseignants voulez-vous créer ?', 30);
        
        $this->command->info("🔄 Création de {$nombreEnseignants} enseignants...");

        $enseignantsCrees = 0;
        $utilisateursCrees = 0;

        for ($i = 0; $i < $nombreEnseignants; $i++) {
            // Générer les données de base
            $genre = rand(0, 1) ? 'M' : 'F';
            $prenom = $this->getPrenomAleatoire($genre);
            $nom = $this->noms[array_rand($this->noms)];
            $specialite = $this->specialites[array_rand($this->specialites)];
            $email = strtolower($prenom . '.' . $nom . rand(1, 999)) . '@ecole.fr';
            $dateNaissance = $this->genererDateNaissance();

            // Créer un utilisateur associé (optionnel)
            $user = null;
            if (rand(0, 1)) { // 50% des enseignants ont un compte utilisateur
                $user = User::create([
                    'name' => $prenom . ' ' . $nom,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $utilisateursCrees++;
            }

            // Créer l'enseignant
            $enseignant = Enseignant::create([
                'user_id' => $user?->id,
                'matricule' => Enseignant::genererMatricule($nom),
                'nom' => $nom,
                'prenom' => $prenom,
                'genre' => $genre,
                'date_naissance' => $dateNaissance,
                'lieu_naissance' => $this->villes[array_rand($this->villes)],
                'telephone' => $this->genererTelephone(),
                'email' => $email,
                'adresse' => $this->genererAdresse(),
                'specialite' => $specialite,
                'photo' => null,
                'statut' => rand(0, 10) > 1, // 90% des enseignants sont actifs
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $enseignantsCrees++;

            // Afficher la progression
            if (($i + 1) % 10 == 0) {
                $this->command->line("✅ {$i}/{$nombreEnseignants} enseignants créés...");
            }
        }

        // Afficher le résumé
        $this->afficherResume($enseignantsCrees, $utilisateursCrees);
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
     * Afficher un résumé des créations
     */
    private function afficherResume(int $enseignantsCrees, int $utilisateursCrees): void
    {
        $totalEnseignants = Enseignant::count();
        $actifs = Enseignant::where('statut', true)->count();
        $statsSpecialites = Enseignant::selectRaw('specialite, count(*) as total')
            ->groupBy('specialite')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES ENSEIGNANTS CRÉÉS');
        $this->command->info("Total enseignants : {$totalEnseignants}");
        $this->command->info("Enseignants actifs : {$actifs}");
        $this->command->info("Comptes utilisateur créés : {$utilisateursCrees}");
        $this->command->info("Taux d'activité : " . round(($actifs / $totalEnseignants) * 100, 1) . "%");
        $this->command->info('------------------------------------');
        $this->command->info('📚 Top 5 des spécialités :');
        
        foreach ($statsSpecialites as $stat) {
            $pourcentage = round(($stat->total / $totalEnseignants) * 100, 1);
            $this->command->line("  • {$stat->specialite} : {$stat->total} ({$pourcentage}%)");
        }
        
        $this->command->info('====================================');
        $this->command->info('✅ Seeder Enseignant exécuté avec succès !');
    }
}