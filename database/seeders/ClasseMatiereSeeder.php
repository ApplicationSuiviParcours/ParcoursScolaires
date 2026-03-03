<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClasseMatiere;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use Illuminate\Support\Facades\DB;

class ClasseMatiereSeeder extends Seeder
{
    /**
     * Coefficients par niveau et type de matière
     */
    private array $coefficients = [
        'primaire' => [
            'Mathématiques' => 5,
            'Français' => 5,
            'Lecture' => 3,
            'Ecriture' => 3,
            'Sciences' => 3,
            'Histoire-Géo' => 2,
            'Education physique' => 1,
            'Dessin' => 1,
            'Musique' => 1,
        ],
        'college' => [
            'Mathématiques' => 4,
            'Français' => 4,
            'Anglais' => 3,
            'Histoire-Géo' => 3,
            'Sciences' => 3,
            'Physique-Chimie' => 3,
            'SVT' => 3,
            'Education physique' => 2,
            'Arts plastiques' => 1,
            'Musique' => 1,
            'Technologie' => 2,
        ],
        'lycee' => [
            'Mathématiques' => 5,
            'Français' => 4,
            'Philosophie' => 3,
            'Anglais' => 3,
            'Histoire-Géo' => 3,
            'Physique-Chimie' => 4,
            'SVT' => 4,
            'Education physique' => 2,
            'LV2' => 2,
            'LV3' => 1,
        ],
        'superieur' => [
            'Mathématiques' => 4,
            'Informatique' => 5,
            'Programmation' => 5,
            'Base de données' => 4,
            'Réseaux' => 4,
            'Anglais technique' => 2,
            'Communication' => 2,
            'Gestion de projet' => 3,
            'Algorithmique' => 4,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer toutes les classes et matières
        $classes = Classe::with('anneeScolaire')->get();
        $matieres = Matiere::all();

        if ($classes->isEmpty()) {
            $this->command->error('❌ Aucune classe trouvée. Veuillez d\'abord exécuter ClasseSeeder');
            return;
        }

        if ($matieres->isEmpty()) {
            $this->command->error('❌ Aucune matière trouvée. Veuillez d\'abord exécuter MatiereSeeder');
            return;
        }

        // Supprimer les anciennes associations (optionnel)
        // ClasseMatiere::truncate();

        $this->command->info('🔄 Création des associations classes-matières...');

        $totalAssociations = 0;
        $anneeScolaireActive = AnneeScolaire::active()->first();

        foreach ($classes as $classe) {
            // Déterminer le niveau pour choisir les coefficients appropriés
            $niveau = $this->determinerNiveau($classe->niveau);
            $coefficientsNiveau = $this->coefficients[$niveau] ?? $this->coefficients['college'];

            // Sélectionner les matières appropriées pour ce niveau
            $matieresDuNiveau = $this->filtrerMatieresParNiveau($matieres, $niveau, $classe->niveau);

            foreach ($matieresDuNiveau as $matiere) {
                // Déterminer le coefficient
                $coefficient = $this->determinerCoefficient($matiere->nom, $coefficientsNiveau, $niveau);

                // Vérifier si l'association existe déjà
                $existing = ClasseMatiere::where('classe_id', $classe->id)
                    ->where('matiere_id', $matiere->id)
                    ->first();

                if (!$existing) {
                    ClasseMatiere::create([
                        'classe_id' => $classe->id,
                        'matiere_id' => $matiere->id,
                        'coefficient' => $coefficient,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $totalAssociations++;
                }
            }

            // Ajouter des matières spécifiques selon la série pour le lycée
            if (in_array($classe->niveau, ['Seconde', 'Première', 'Terminale']) && $classe->serie) {
                $this->ajouterMatieresSerie($classe, $matieres, $classe->serie);
            }
        }

        $this->afficherResume($totalAssociations);
    }

    /**
     * Déterminer le niveau général à partir du niveau de la classe
     */
    private function determinerNiveau(string $niveauClasse): string
    {
        $niveauClasse = strtolower($niveauClasse);
        
        if (in_array($niveauClasse, ['cp1', 'cp2', 'ce1', 'ce2', 'cm1', 'cm2'])) {
            return 'primaire';
        }
        
        if (in_array($niveauClasse, ['6ème', '5ème', '4ème', '3ème'])) {
            return 'college';
        }
        
        if (in_array($niveauClasse, ['seconde', 'première', 'terminale'])) {
            return 'lycee';
        }
        
        if (str_contains($niveauClasse, 'licence') || str_contains($niveauClasse, 'master')) {
            return 'superieur';
        }
        
        return 'college'; // Par défaut
    }

    /**
     * Filtrer les matières par niveau
     */
    private function filtrerMatieresParNiveau($matieres, string $niveau, string $niveauClasse): array
    {
        $matieresFiltrees = [];
        
        // Mots-clés pour identifier les matières par niveau
        $motsCles = [
            'primaire' => ['lecture', 'écriture', 'dessin', 'musique'],
            'college' => ['technologie', 'physique', 'svt'],
            'lycee' => ['philosophie', 'lv2', 'lv3'],
            'superieur' => ['informatique', 'programmation', 'base de données', 'réseaux', 'algorithmique'],
        ];

        foreach ($matieres as $matiere) {
            $nomMatiere = strtolower($matiere->nom);
            
            // Toujours inclure les matières de base
            if (in_array($nomMatiere, ['mathématiques', 'français', 'anglais', 'histoire-géo'])) {
                $matieresFiltrees[] = $matiere;
                continue;
            }

            // Vérifier si la matière correspond au niveau
            foreach ($motsCles as $key => $mots) {
                if ($key === $niveau) {
                    foreach ($mots as $mot) {
                        if (str_contains($nomMatiere, $mot)) {
                            $matieresFiltrees[] = $matiere;
                            break 2;
                        }
                    }
                }
            }
        }

        // Si pas assez de matières, ajouter quelques matières aléatoires
        if (count($matieresFiltrees) < 5) {
            $matieresFiltrees = $matieres->take(8)->all();
        }

        return array_slice($matieresFiltrees, 0, 10); // Max 10 matières par classe
    }

    /**
     * Déterminer le coefficient d'une matière
     */
    private function determinerCoefficient(string $nomMatiere, array $coefficients, string $niveau): int
    {
        $nomMatiere = strtolower($nomMatiere);
        
        foreach ($coefficients as $matiere => $coeff) {
            if (str_contains($nomMatiere, strtolower($matiere))) {
                return $coeff;
            }
        }

        // Coefficient par défaut selon le niveau
        return match($niveau) {
            'primaire' => rand(2, 4),
            'college' => rand(2, 4),
            'lycee' => rand(3, 5),
            'superieur' => rand(3, 5),
            default => rand(2, 3),
        };
    }

    /**
     * Ajouter des matières spécifiques selon la série
     */
    private function ajouterMatieresSerie($classe, $matieres, string $serie): void
    {
        $matieresSerie = [
            'A' => ['Philosophie', 'Littérature', 'Histoire-Géo', 'Langues'],
            'C' => ['Mathématiques', 'Physique-Chimie', 'SVT', 'Technologie'],
            'D' => ['Mathématiques', 'SVT', 'Physique-Chimie', 'Sciences'],
            'S' => ['Mathématiques', 'Physique-Chimie', 'SVT', 'Informatique'],
            'ES' => ['SES', 'Mathématiques', 'Histoire-Géo', 'Philosophie'],
            'L' => ['Philosophie', 'Littérature', 'Langues', 'Arts'],
        ];

        $matieresASerie = $matieresSerie[$serie] ?? [];

        foreach ($matieres as $matiere) {
            foreach ($matieresASerie as $nomMatiere) {
                if (str_contains($matiere->nom, $nomMatiere) || str_contains($nomMatiere, $matiere->nom)) {
                    ClasseMatiere::firstOrCreate([
                        'classe_id' => $classe->id,
                        'matiere_id' => $matiere->id,
                    ], [
                        'coefficient' => rand(3, 6),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Afficher un résumé des associations créées
     */
    private function afficherResume(int $totalAssociations): void
    {
        $stats = ClasseMatiere::select('classe_id', DB::raw('count(*) as total'))
            ->groupBy('classe_id')
            ->get();

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES ASSOCIATIONS CLASSES-MATIÈRES');
        $this->command->info("Total associations créées : {$totalAssociations}");
        $this->command->info('------------------------------------');
        
        foreach ($stats as $stat) {
            $classe = Classe::find($stat->classe_id);
            if ($classe) {
                $this->command->line("{$classe->nom_complet} : {$stat->total} matières");
            }
        }
        
        $this->command->info('====================================');
        $this->command->info('✅ Seeder ClasseMatiere exécuté avec succès !');
    }
}