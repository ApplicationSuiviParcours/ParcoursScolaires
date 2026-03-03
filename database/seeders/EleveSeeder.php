<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Inscription;
use App\Models\ParentEleve;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class EleveSeeder extends Seeder
{
    /**
     * Liste des prénoms français
     */
    private array $prenoms = [
        'Lucas', 'Emma', 'Louis', 'Jade', 'Hugo', 'Louise', 'Gabriel', 'Alice',
        'Raphaël', 'Chloé', 'Jules', 'Léa', 'Adam', 'Manon', 'Arthur', 'Lina',
        'Paul', 'Juliette', 'Alexandre', 'Sarah', 'Antoine', 'Camille', 'Thomas', 'Zoé',
        'Pierre', 'Eva', 'Nicolas', 'Anna', 'Maxime', 'Rose', 'Quentin', 'Mila',
        'Bastien', 'Inès', 'Victor', 'Agathe', 'Clément', 'Nina', 'Mathis', 'Léna',
        'Théo', 'Lola', 'Valentin', 'Julia', 'Benjamin', 'Elisa', 'Romain', 'Lucie',
        'Kylian', 'Marie', 'Baptiste', 'Margaux', 'Enzo', 'Clara', 'Alexis', 'Pauline',
        'Nolan', 'Laura', 'Maxence', 'Célia', 'Ethan', 'Morgane', 'Côme', 'Océane'
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
        'Nicolas', 'Perrin', 'Morin', 'Mathieu', 'Clement', 'Gauthier', 'Dumont', 'Lopez',
        'Fontaine', 'Chevalier', 'Robin', 'Masson', 'Sanchez', 'Gerard', 'Nguyen', 'Boyer'
    ];

    /**
     * Liste des villes de naissance
     */
    private array $villes = [
        'Paris', 'Lyon', 'Marseille', 'Toulouse', 'Bordeaux', 'Lille', 'Strasbourg',
        'Nantes', 'Rennes', 'Grenoble', 'Montpellier', 'Nice', 'Dijon', 'Orléans',
        'Tours', 'Clermont-Ferrand', 'Le Havre', 'Saint-Étienne', 'Caen', 'Angers'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        // Récupérer les données nécessaires
        $anneeScolaire = AnneeScolaire::active()->first() ?? AnneeScolaire::first();
        $classes = Classe::all();

        if (!$anneeScolaire) {
            $this->command->error('❌ Aucune année scolaire trouvée. Veuillez d\'abord exécuter AnneeScolaireSeeder');
            return;
        }

        if ($classes->isEmpty()) {
            $this->command->error('❌ Aucune classe trouvée. Veuillez d\'abord exécuter ClasseSeeder');
            return;
        }

        // Demander le nombre d'élèves à créer
        $nombreEleves = $this->command->ask('Combien d\'élèves voulez-vous créer ?', 50);

        $this->command->info("🔄 Création de {$nombreEleves} élèves...");

        // Créer les parents (si la table parent_eleve existe)
        $parents = $this->creerParents($nombreEleves / 2); // Environ 1 parent pour 2 élèves

        $elevesCreer = 0;
        $inscriptionsCreer = 0;
        $compteurClasse = [];

        for ($i = 0; $i < $nombreEleves; $i++) {
            // Sélectionner une classe aléatoire
            $classe = $classes->random();

            // Vérifier la capacité de la classe
            $compteurClasse[$classe->id] = ($compteurClasse[$classe->id] ?? 0) + 1;

            if ($compteurClasse[$classe->id] > $classe->capacite) {
                // Classe pleine, passer à une autre
                $classe = $classes->whereNotIn('id', array_keys(array_filter($compteurClasse,
                    function($count) use ($classe) {
                        return $count >= $classe->capacite;
                    }
                )))->random();
                $compteurClasse[$classe->id] = ($compteurClasse[$classe->id] ?? 0) + 1;
            }

            // Générer les données de l'élève
            $genre = rand(0, 1) ? 'M' : 'F';
            $prenom = $this->getPrenomAleatoire($genre);
            $nom = $this->noms[array_rand($this->noms)];
            $dateNaissance = $this->genererDateNaissance($classe->niveau);
            $email = strtolower($prenom . '.' . $nom . rand(1, 999)) . '@exemple.com';

            // Créer l'élève
            $eleve = Eleve::create([
                'nom' => $nom,
                'prenom' => $prenom,
                'matricule' => Eleve::genererMatricule($nom),
                'date_naissance' => $dateNaissance,
                'lieu_naissance' => $this->villes[array_rand($this->villes)],
                'genre' => $genre,
                'adresse' => rand(1, 100) . ' Rue ' . $faker->streetName . ', ' . $faker->city,
                'telephone' => $this->genererTelephone(),
                'email' => $email,
                'photo' => null,
                'date_inscription' => $anneeScolaire->date_debut,
                'statut' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Créer l'inscription de l'élève
            $inscription = Inscription::create([
                'eleve_id' => $eleve->id,
                'classe_id' => $classe->id,
                'annee_scolaire_id' => $anneeScolaire->id,
                'date_inscription' => Carbon::parse($anneeScolaire->date_debut)->addDays(rand(1, 15)),
                'statut' => true,
                'observation' => rand(0, 1) ? null : $this->getObservationAleatoire(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Associer des parents aléatoires à l'élève
            if ($parents->isNotEmpty() && rand(0, 1)) {
                $nombreParents = rand(1, 2);
                $parentsSelectionnes = $parents->random($nombreParents);

                foreach ($parentsSelectionnes as $parent) {
                    $eleve->parents()->attach($parent->id, [
                        'lien_parental' => $this->getLienParentalAleatoire($parent->genre),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Créer un compte utilisateur pour l'élève (optionnel)
            if (rand(0, 1)) {
                $user = User::create([
                    'name' => $eleve->nom_complet,
                    'email' => 'user_' . $eleve->email,
                    'password' => Hash::make('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $eleve->update(['user_id' => $user->id]);
            }

            $elevesCreer++;
            $inscriptionsCreer++;

            // Afficher la progression
            if (($i + 1) % 10 == 0) {
                $this->command->line("✅ {$i}/{$nombreEleves} élèves créés...");
            }
        }

        // Créer des inscriptions historiques pour certains élèves
        $this->creerInscriptionsHistoriques($elevesCreer, $classes, $anneeScolaire);

        // Afficher le résumé
        $this->afficherResume($elevesCreer, $inscriptionsCreer, $classes, $compteurClasse);
    }

    /**
     * Créer des parents d'élèves
     */
    private function creerParents(int $nombre)
    {
        if (!class_exists(ParentEleve::class)) {
            return collect([]);
        }

        $parents = collect([]);

        for ($i = 0; $i < $nombre; $i++) {
            $genre = rand(0, 1) ? 'M' : 'F';
            $prenom = $this->getPrenomAleatoire($genre);
            $nom = $this->noms[array_rand($this->noms)];

            $parent = ParentEleve::create([
                'nom' => $nom,
                'prenom' => $prenom,
                'profession' => $this->getProfessionAleatoire(),
                'telephone' => $this->genererTelephone(),
                'email' => strtolower($prenom . '.' . $nom . rand(1, 999)) . '@parent.fr',
                'adresse' => $this->genererAdresse(),
                'genre' => $genre,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $parents->push($parent);
        }

        return $parents;
    }

    /**
     * Créer des inscriptions historiques (années précédentes)
     */
    private function creerInscriptionsHistoriques(int $nombreEleves, $classes, $anneeScolaireActuelle): void
    {
        // Récupérer les années scolaires précédentes
        $anneesPrecedentes = AnneeScolaire::where('date_fin', '<', $anneeScolaireActuelle->date_debut)
            ->orderBy('date_debut', 'desc')
            ->take(2)
            ->get();

        if ($anneesPrecedentes->isEmpty()) {
            return;
        }

        $eleves = Eleve::inRandomOrder()->take($nombreEleves * 0.3)->get(); // 30% des élèves ont un historique

        foreach ($eleves as $eleve) {
            $anneePrecedente = $anneesPrecedentes->random();
            $classePrecedente = $classes->random();

            // Vérifier si l'élève n'a pas déjà une inscription pour cette année
            $existe = Inscription::where('eleve_id', $eleve->id)
                ->where('annee_scolaire_id', $anneePrecedente->id)
                ->exists();

            if (!$existe) {
                Inscription::create([
                    'eleve_id' => $eleve->id,
                    'classe_id' => $classePrecedente->id,
                    'annee_scolaire_id' => $anneePrecedente->id,
                    'date_inscription' => Carbon::parse($anneePrecedente->date_debut)->addDays(rand(1, 10)),
                    'statut' => false, // Inscription ancienne donc inactive
                    'observation' => 'Inscription année précédente',
                    'created_at' => now()->subYear(),
                    'updated_at' => now()->subYear(),
                ]);
            }
        }
    }

    /**
     * Générer une date de naissance en fonction du niveau
     */
    private function genererDateNaissance(string $niveau): Carbon
    {
        $age = match(true) {
            str_contains($niveau, 'CP1') || str_contains($niveau, 'CP2') => rand(6, 7),
            str_contains($niveau, 'CE1') || str_contains($niveau, 'CE2') => rand(8, 9),
            str_contains($niveau, 'CM1') || str_contains($niveau, 'CM2') => rand(10, 11),
            str_contains($niveau, '6ème') || str_contains($niveau, '5ème') => rand(11, 13),
            str_contains($niveau, '4ème') || str_contains($niveau, '3ème') => rand(14, 15),
            str_contains($niveau, 'Seconde') => rand(15, 16),
            str_contains($niveau, 'Première') => rand(16, 17),
            str_contains($niveau, 'Terminale') => rand(17, 19),
            str_contains($niveau, 'Licence') => rand(18, 22),
            str_contains($niveau, 'Master') => rand(22, 25),
            default => rand(10, 18),
        };

        return Carbon::now()->subYears($age)->subDays(rand(1, 365));
    }

    /**
     * Obtenir un prénom aléatoire selon le genre
     */
    private function getPrenomAleatoire(string $genre): string
    {
        $prenomsF = ['Emma', 'Jade', 'Louise', 'Alice', 'Chloé', 'Léa', 'Manon', 'Lina', 'Juliette', 'Sarah', 'Camille', 'Zoé', 'Eva', 'Anna', 'Rose', 'Mila', 'Inès', 'Agathe', 'Nina', 'Léna', 'Lola', 'Julia', 'Elisa', 'Lucie', 'Marie', 'Margaux', 'Clara', 'Pauline', 'Laura', 'Célia', 'Morgane', 'Océane'];
        $prenomsM = ['Lucas', 'Louis', 'Hugo', 'Gabriel', 'Raphaël', 'Jules', 'Adam', 'Arthur', 'Paul', 'Alexandre', 'Antoine', 'Thomas', 'Pierre', 'Nicolas', 'Maxime', 'Quentin', 'Bastien', 'Victor', 'Clément', 'Mathis', 'Théo', 'Valentin', 'Benjamin', 'Romain', 'Kylian', 'Baptiste', 'Enzo', 'Alexis', 'Nolan', 'Maxence', 'Ethan', 'Côme'];

        if ($genre === 'F') {
            return $prenomsF[array_rand($prenomsF)];
        } else {
            return $prenomsM[array_rand($prenomsM)];
        }
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
        return rand(1, 100) . ' ' . $faker->streetName . ', ' . $faker->city . ' ' . rand(10000, 95999);
    }

    /**
     * Obtenir une observation aléatoire
     */
    private function getObservationAleatoire(): string
    {
        $observations = [
            'Frais d\'inscription payés',
            'Dossier incomplet (photo manquante)',
            'Boursier',
            'Demi-pensionnaire',
            'Externe',
            'Interné',
            'Vient du public',
            'Redoublant',
            'Nouveau dans l\'établissement',
        ];

        return $observations[array_rand($observations)];
    }

    /**
     * Obtenir une profession aléatoire
     */
    private function getProfessionAleatoire(): string
    {
        $professions = [
            'Enseignant', 'Médecin', 'Avocat', 'Ingénieur', 'Commerçant',
            'Fonctionnaire', 'Artisan', 'Infirmier', 'Cadre', 'Agent commercial',
            'Architecte', 'Comptable', 'Journaliste', 'Consultant', 'Entrepreneur',
            'Sans emploi', 'Retraité', 'Agent de sécurité', 'Chauffeur', 'Agriculteur'
        ];

        return $professions[array_rand($professions)];
    }

    /**
     * Obtenir le lien parental aléatoire
     */
    private function getLienParentalAleatoire(?string $genreParent): string
    {
        if ($genreParent === 'F') {
            return rand(0, 1) ? 'Mère' : 'Tante';
        } else {
            return rand(0, 1) ? 'Père' : 'Oncle';
        }
    }

    /**
     * Afficher un résumé des créations
     */
    private function afficherResume(int $elevesCreer, int $inscriptionsCreer, $classes, array $compteurClasse): void
    {
        $totalEleves = Eleve::count();
        $totalInscriptions = Inscription::count();
        $elevesActifs = Eleve::where('statut', true)->count();

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES ÉLÈVES CRÉÉS');
        $this->command->info("Total élèves : {$totalEleves}");
        $this->command->info("Élèves actifs : {$elevesActifs}");
        $this->command->info("Total inscriptions : {$totalInscriptions}");
        $this->command->info('------------------------------------');
        $this->command->info('📚 Répartition par classe :');

        foreach ($compteurClasse as $classeId => $count) {
            $classe = $classes->find($classeId);
            if ($classe) {
                $pourcentage = round(($count / $classe->capacite) * 100, 1);
                $this->command->line("  {$classe->nom_complet} : {$count}/{$classe->capacite} élèves ({$pourcentage}%)");
            }
        }

        $this->command->info('====================================');
        $this->command->info('✅ Seeder Eleve exécuté avec succès !');
    }
}
