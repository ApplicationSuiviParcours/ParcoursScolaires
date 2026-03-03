<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Matiere;
use App\Models\Enseignant;
use App\Models\ClasseMatiere;
use App\Models\EnseignantMatiereClasse;
use Illuminate\Support\Facades\DB;

class ClasseSeeder extends Seeder
{
    /**
     * Niveaux scolaires disponibles
     */
    private array $niveaux = [
        '6ème', '5ème', '4ème', '3ème',
        'Seconde', 'Première', 'Terminale',
        'CP1', 'CP2', 'CE1', 'CE2', 'CM1', 'CM2',
        'Licence 1', 'Licence 2', 'Licence 3',
        'Master 1', 'Master 2'
    ];

    /**
     * Séries disponibles pour le lycée
     */
    private array $series = [
        'A', 'B', 'C', 'D', 'E', 
        'L', 'S', 'ES', 'STG', 'STI',
        'A1', 'A2', 'B', 'C', 'D'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer l'année scolaire active
        $anneeScolaire = AnneeScolaire::active()->first() ?? AnneeScolaire::first();
        
        if (!$anneeScolaire) {
            $this->command->error('❌ Aucune année scolaire trouvée. Veuillez d\'abord exécuter AnneeScolaireSeeder');
            return;
        }

        // Récupérer les matières et enseignants existants
        $matieres = Matiere::all();
        $enseignants = Enseignant::all();

        if ($matieres->isEmpty()) {
            $this->command->warn('⚠️ Aucune matière trouvée. Les relations matières ne seront pas créées.');
        }

        if ($enseignants->isEmpty()) {
            $this->command->warn('⚠️ Aucun enseignant trouvé. Les affectations d\'enseignants ne seront pas créées.');
        }

        // Supprimer les classes existantes pour l'année scolaire (optionnel)
        // Classe::where('annee_scolaire_id', $anneeScolaire->id)->delete();

        // Créer les classes par niveau
        $this->creerClassesCollege($anneeScolaire->id, $matieres, $enseignants);
        $this->creerClassesLycee($anneeScolaire->id, $matieres, $enseignants);
        $this->creerClassesPrimaire($anneeScolaire->id, $matieres, $enseignants);
        $this->creerClassesSuperieur($anneeScolaire->id, $matieres, $enseignants);

        // Afficher le résumé
        $this->afficherResume($anneeScolaire->nom);
    }

    /**
     * Créer les classes du collège
     */
    private function creerClassesCollege(int $anneeScolaireId, $matieres, $enseignants): void
    {
        $classesCollege = [
            ['nom' => 'A', 'niveau' => '6ème', 'capacite' => 40],
            ['nom' => 'B', 'niveau' => '6ème', 'capacite' => 40],
            ['nom' => 'A', 'niveau' => '5ème', 'capacite' => 40],
            ['nom' => 'B', 'niveau' => '5ème', 'capacite' => 40],
            ['nom' => 'A', 'niveau' => '4ème', 'capacite' => 35],
            ['nom' => 'B', 'niveau' => '4ème', 'capacite' => 35],
            ['nom' => 'A', 'niveau' => '3ème', 'capacite' => 30],
            ['nom' => 'B', 'niveau' => '3ème', 'capacite' => 30],
        ];

        foreach ($classesCollege as $classeData) {
            $classe = Classe::create([
                'nom' => $classeData['nom'],
                'niveau' => $classeData['niveau'],
                'serie' => null,
                'capacite' => $classeData['capacite'],
                'annee_scolaire_id' => $anneeScolaireId,
            ]);

            $this->command->line("✅ Classe créée : {$classe->nom_complet}");

            // Ajouter les matières et enseignants
            $this->ajouterMatièresEtEnseignants($classe, $matieres, $enseignants);
        }
    }

    /**
     * Créer les classes du lycée
     */
    private function creerClassesLycee(int $anneeScolaireId, $matieres, $enseignants): void
    {
        $classesLycee = [
            // Seconde
            ['nom' => 'A', 'niveau' => 'Seconde', 'serie' => 'A', 'capacite' => 35],
            ['nom' => 'B', 'niveau' => 'Seconde', 'serie' => 'C', 'capacite' => 35],
            ['nom' => 'C', 'niveau' => 'Seconde', 'serie' => 'D', 'capacite' => 35],
            // Première
            ['nom' => 'A', 'niveau' => 'Première', 'serie' => 'A', 'capacite' => 30],
            ['nom' => 'B', 'niveau' => 'Première', 'serie' => 'C', 'capacite' => 30],
            ['nom' => 'C', 'niveau' => 'Première', 'serie' => 'D', 'capacite' => 30],
            // Terminale
            ['nom' => 'A', 'niveau' => 'Terminale', 'serie' => 'A', 'capacite' => 25],
            ['nom' => 'B', 'niveau' => 'Terminale', 'serie' => 'C', 'capacite' => 25],
            ['nom' => 'C', 'niveau' => 'Terminale', 'serie' => 'D', 'capacite' => 25],
        ];

        foreach ($classesLycee as $classeData) {
            $classe = Classe::create([
                'nom' => $classeData['nom'],
                'niveau' => $classeData['niveau'],
                'serie' => $classeData['serie'],
                'capacite' => $classeData['capacite'],
                'annee_scolaire_id' => $anneeScolaireId,
            ]);

            $this->command->line("✅ Classe créée : {$classe->nom_complet}");

            // Ajouter les matières et enseignants
            $this->ajouterMatièresEtEnseignants($classe, $matieres, $enseignants);
        }
    }

    /**
     * Créer les classes du primaire
     */
    private function creerClassesPrimaire(int $anneeScolaireId, $matieres, $enseignants): void
    {
        $classesPrimaire = [
            ['nom' => 'A', 'niveau' => 'CP1', 'capacite' => 30],
            ['nom' => 'B', 'niveau' => 'CP1', 'capacite' => 30],
            ['nom' => 'A', 'niveau' => 'CP2', 'capacite' => 30],
            ['nom' => 'A', 'niveau' => 'CE1', 'capacite' => 35],
            ['nom' => 'B', 'niveau' => 'CE1', 'capacite' => 35],
            ['nom' => 'A', 'niveau' => 'CE2', 'capacite' => 35],
            ['nom' => 'A', 'niveau' => 'CM1', 'capacite' => 35],
            ['nom' => 'B', 'niveau' => 'CM1', 'capacite' => 35],
            ['nom' => 'A', 'niveau' => 'CM2', 'capacite' => 30],
        ];

        foreach ($classesPrimaire as $classeData) {
            $classe = Classe::create([
                'nom' => $classeData['nom'],
                'niveau' => $classeData['niveau'],
                'serie' => null,
                'capacite' => $classeData['capacite'],
                'annee_scolaire_id' => $anneeScolaireId,
            ]);

            $this->command->line("✅ Classe créée : {$classe->nom_complet}");

            // Ajouter les matières et enseignants
            $this->ajouterMatièresEtEnseignants($classe, $matieres, $enseignants);
        }
    }

    /**
     * Créer les classes du supérieur
     */
    private function creerClassesSuperieur(int $anneeScolaireId, $matieres, $enseignants): void
    {
        $classesSuperieur = [
            ['nom' => 'Informatique', 'niveau' => 'Licence 1', 'capacite' => 50],
            ['nom' => 'Informatique', 'niveau' => 'Licence 2', 'capacite' => 45],
            ['nom' => 'Informatique', 'niveau' => 'Licence 3', 'capacite' => 40],
            ['nom' => 'Gestion', 'niveau' => 'Licence 1', 'capacite' => 50],
            ['nom' => 'Gestion', 'niveau' => 'Licence 2', 'capacite' => 45],
            ['nom' => 'Gestion', 'niveau' => 'Licence 3', 'capacite' => 40],
            ['nom' => 'Informatique', 'niveau' => 'Master 1', 'capacite' => 30],
            ['nom' => 'Informatique', 'niveau' => 'Master 2', 'capacite' => 25],
        ];

        foreach ($classesSuperieur as $classeData) {
            $classe = Classe::create([
                'nom' => $classeData['nom'],
                'niveau' => $classeData['niveau'],
                'serie' => null,
                'capacite' => $classeData['capacite'],
                'annee_scolaire_id' => $anneeScolaireId,
            ]);

            $this->command->line("✅ Classe créée : {$classe->nom_complet}");

            // Ajouter les matières et enseignants
            $this->ajouterMatièresEtEnseignants($classe, $matieres, $enseignants);
        }
    }

    /**
     * Ajouter les matières et enseignants à une classe
     */
    private function ajouterMatièresEtEnseignants(Classe $classe, $matieres, $enseignants): void
    {
        if ($matieres->isEmpty()) {
            return;
        }

        // Sélectionner aléatoirement 5 à 8 matières pour cette classe
        $matieresSelectionnees = $matieres->random(min(rand(5, 8), $matieres->count()));

        foreach ($matieresSelectionnees as $matiere) {
            // Créer la classe matière (relation dans ClasseMatiere)
            ClasseMatiere::create([
                'classe_id' => $classe->id,
                'matiere_id' => $matiere->id,
                'coefficient' => rand(1, 5),
                // 'heures_semaine' => rand(2, 6),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Si des enseignants existent, affecter un enseignant à cette matière pour la classe
            if ($enseignants->isNotEmpty()) {
                $enseignant = $enseignants->random();
                
                // Créer la relation EnseignantMatiereClasse
                EnseignantMatiereClasse::create([
                    'enseignant_id' => $enseignant->id,
                    'matiere_id' => $matiere->id,
                    'classe_id' => $classe->id,
                    'annee_scolaire_id' => $classe->annee_scolaire_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Afficher un résumé des classes créées
     */
    private function afficherResume(string $anneeScolaire): void
    {
        $totalClasses = Classe::count();
        $classesParNiveau = Classe::select('niveau', DB::raw('count(*) as total'))
            ->groupBy('niveau')
            ->orderBy('niveau')
            ->get();

        $this->command->info('====================================');
        $this->command->info("📊 RÉSUMÉ DES CLASSES CRÉÉES");
        $this->command->info("Année scolaire : {$anneeScolaire}");
        $this->command->info("Total classes : {$totalClasses}");
        $this->command->info('------------------------------------');
        
        foreach ($classesParNiveau as $item) {
            $this->command->line("{$item->niveau} : {$item->total} classe(s)");
        }
        
        $this->command->info('====================================');
        $this->command->info('✅ Seeder Classe exécuté avec succès !');
    }
}