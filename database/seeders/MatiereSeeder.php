<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matiere;
use Illuminate\Support\Str;

class MatiereSeeder extends Seeder
{
    /**
     * Liste des matières avec leurs codes et coefficients par défaut
     */
    private array $matieres = [
        // Matières fondamentales
        [
            'nom' => 'Mathématiques',
            'code' => 'MATH',
            'description' => 'Étude des nombres, des structures, de l\'espace et des transformations.',
            'coefficient' => 5,
        ],
        [
            'nom' => 'Français',
            'code' => 'FR',
            'description' => 'Étude de la langue française, de la littérature et de la communication.',
            'coefficient' => 5,
        ],
        [
            'nom' => 'Anglais',
            'code' => 'ANG',
            'description' => 'Apprentissage de la langue anglaise et de la culture anglophone.',
            'coefficient' => 4,
        ],
        [
            'nom' => 'Histoire-Géographie',
            'code' => 'HG',
            'description' => 'Étude du passé et des espaces géographiques.',
            'coefficient' => 3,
        ],
        [
            'nom' => 'Education Civique et Morale',
            'code' => 'ECM',
            'description' => 'Apprentissage des valeurs citoyennes et morales.',
            'coefficient' => 2,
        ],

        // Sciences
        [
            'nom' => 'Physique-Chimie',
            'code' => 'PC',
            'description' => 'Étude des phénomènes physiques et chimiques.',
            'coefficient' => 4,
        ],
        [
            'nom' => 'Sciences de la Vie et de la Terre',
            'code' => 'SVT',
            'description' => 'Étude du vivant et de la Terre.',
            'coefficient' => 4,
        ],
        [
            'nom' => 'Technologie',
            'code' => 'TECH',
            'description' => 'Étude des techniques et des systèmes technologiques.',
            'coefficient' => 3,
        ],

        // Langues
        [
            'nom' => 'Espagnol',
            'code' => 'ESP',
            'description' => 'Apprentissage de la langue espagnole et de la culture hispanique.',
            'coefficient' => 3,
        ],
        [
            'nom' => 'Allemand',
            'code' => 'ALL',
            'description' => 'Apprentissage de la langue allemande et de la culture germanique.',
            'coefficient' => 3,
        ],
        [
            'nom' => 'Italien',
            'code' => 'ITA',
            'description' => 'Apprentissage de la langue italienne et de la culture italienne.',
            'coefficient' => 3,
        ],
        [
            'nom' => 'Latin',
            'code' => 'LAT',
            'description' => 'Étude de la langue latine et de la civilisation romaine.',
            'coefficient' => 2,
        ],
        [
            'nom' => 'Grec ancien',
            'code' => 'GREC',
            'description' => 'Étude de la langue grecque ancienne et de la civilisation grecque.',
            'coefficient' => 2,
        ],

        // Arts et Sports
        [
            'nom' => 'Education Physique et Sportive',
            'code' => 'EPS',
            'description' => 'Pratique sportive et éducation à la santé.',
            'coefficient' => 3,
        ],
        [
            'nom' => 'Arts Plastiques',
            'code' => 'AP',
            'description' => 'Pratique des arts visuels et étude de l\'histoire de l\'art.',
            'coefficient' => 2,
        ],
        [
            'nom' => 'Musique',
            'code' => 'MUS',
            'description' => 'Pratique musicale et éducation de l\'oreille.',
            'coefficient' => 2,
        ],

        // Spécialités Lycée
        [
            'nom' => 'Philosophie',
            'code' => 'PHILO',
            'description' => 'Étude des grands courants de pensée et exercice de la réflexion.',
            'coefficient' => 4,
        ],
        [
            'nom' => 'Sciences Économiques et Sociales',
            'code' => 'SES',
            'description' => 'Étude de l\'économie, de la sociologie et de la science politique.',
            'coefficient' => 4,
        ],
        [
            'nom' => 'Numérique et Sciences Informatiques',
            'code' => 'NSI',
            'description' => 'Programmation, algorithmique et culture numérique.',
            'coefficient' => 4,
        ],
        [
            'nom' => 'Sciences de l\'Ingénieur',
            'code' => 'SI',
            'description' => 'Étude des systèmes techniques et de l\'ingénierie.',
            'coefficient' => 4,
        ],
        [
            'nom' => 'Biotechnologies',
            'code' => 'BIO',
            'description' => 'Étude des applications des sciences du vivant.',
            'coefficient' => 3,
        ],

        // Enseignements professionnels
        [
            'nom' => 'Gestion',
            'code' => 'GEST',
            'description' => 'Principes de gestion et de management.',
            'coefficient' => 3,
        ],
        [
            'nom' => 'Marketing',
            'code' => 'MARK',
            'description' => 'Étude des techniques de marché et de communication.',
            'coefficient' => 3,
        ],
        [
            'nom' => 'Économie',
            'code' => 'ECO',
            'description' => 'Principes économiques fondamentaux.',
            'coefficient' => 3,
        ],
        [
            'nom' => 'Droit',
            'code' => 'DROIT',
            'description' => 'Initiation au droit et aux institutions juridiques.',
            'coefficient' => 3,
        ],

        // Enseignements primaire
        [
            'nom' => 'Lecture',
            'code' => 'LECT',
            'description' => 'Apprentissage de la lecture et compréhension de textes.',
            'coefficient' => 4,
        ],
        [
            'nom' => 'Ecriture',
            'code' => 'ECR',
            'description' => 'Apprentissage de l\'écriture et de la calligraphie.',
            'coefficient' => 3,
        ],
        [
            'nom' => 'Calcul',
            'code' => 'CALC',
            'description' => 'Apprentissage des opérations mathématiques de base.',
            'coefficient' => 4,
        ],
        [
            'nom' => 'Découverte du monde',
            'code' => 'DM',
            'description' => 'Exploration de l\'environnement et des phénomènes naturels.',
            'coefficient' => 2,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔄 Création des matières...');

        $matieresCrees = 0;
        $matieresMisesAJour = 0;

        foreach ($this->matieres as $matiereData) {
            // Vérifier si la matière existe déjà (par nom ou code)
            $existingMatiere = Matiere::where('nom', $matiereData['nom'])
                ->orWhere('code', $matiereData['code'])
                ->first();

            if ($existingMatiere) {
                // Mettre à jour la matière existante
                $existingMatiere->update([
                    'code' => $matiereData['code'],
                    'description' => $matiereData['description'],
                    'coefficient' => $matiereData['coefficient'],
                ]);
                $matieresMisesAJour++;
                $this->command->line("  📝 Mise à jour : {$matiereData['nom']} ({$matiereData['code']})");
            } else {
                // Créer la matière
                Matiere::create([
                    'nom' => $matiereData['nom'],
                    'code' => $matiereData['code'],
                    'description' => $matiereData['description'],
                    'coefficient' => $matiereData['coefficient'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $matieresCrees++;
                $this->command->line("  ✅ Création : {$matiereData['nom']} ({$matiereData['code']})");
            }
        }

        // Ajouter des matières supplémentaires pour les besoins spécifiques
        $matieresSupplementaires = $this->getMatieresSupplementaires();
        foreach ($matieresSupplementaires as $matiereData) {
            $existingMatiere = Matiere::where('nom', $matiereData['nom'])->first();
            if (!$existingMatiere) {
                Matiere::create($matiereData);
                $matieresCrees++;
                $this->command->line("  ✅ Création (supplémentaire) : {$matiereData['nom']}");
            }
        }

        $this->afficherResume($matieresCrees, $matieresMisesAJour);
    }

    /**
     * Obtenir des matières supplémentaires pour couvrir tous les besoins
     */
    private function getMatieresSupplementaires(): array
    {
        return [
            [
                'nom' => 'Informatique',
                'code' => 'INFO',
                'description' => 'Bases de l\'informatique et de l\'utilisation des outils numériques.',
                'coefficient' => 3,
            ],
            [
                'nom' => 'Programmation',
                'code' => 'PROG',
                'description' => 'Apprentissage des langages de programmation et de la logique algorithmique.',
                'coefficient' => 4,
            ],
            [
                'nom' => 'Base de données',
                'code' => 'BDD',
                'description' => 'Conception et utilisation des bases de données.',
                'coefficient' => 3,
            ],
            [
                'nom' => 'Réseaux',
                'code' => 'RES',
                'description' => 'Architecture et administration des réseaux informatiques.',
                'coefficient' => 3,
            ],
            [
                'nom' => 'Algorithmique',
                'code' => 'ALGO',
                'description' => 'Étude des algorithmes et de leur complexité.',
                'coefficient' => 4,
            ],
            [
                'nom' => 'LV2',
                'code' => 'LV2',
                'description' => 'Langue Vivante 2 (au choix).',
                'coefficient' => 3,
            ],
            [
                'nom' => 'LV3',
                'code' => 'LV3',
                'description' => 'Langue Vivante 3 (option).',
                'coefficient' => 2,
            ],
            [
                'nom' => 'Sciences',
                'code' => 'SCI',
                'description' => 'Sciences fondamentales (primaire).',
                'coefficient' => 3,
            ],
            [
                'nom' => 'Dessin',
                'code' => 'DESS',
                'description' => 'Pratique du dessin et des arts graphiques.',
                'coefficient' => 2,
            ],
        ];
    }

    /**
     * Afficher un résumé des matières créées/mises à jour
     */
    private function afficherResume(int $matieresCrees, int $matieresMisesAJour): void
    {
        $totalMatieres = Matiere::count();
        
        // Statistiques par coefficient
        $statsCoefficients = Matiere::selectRaw('coefficient, count(*) as total')
            ->groupBy('coefficient')
            ->orderBy('coefficient')
            ->get();

        // Recherche de matières par mots-clés
        $matieresScientifiques = Matiere::where('nom', 'like', '%Math%')
            ->orWhere('nom', 'like', '%Physique%')
            ->orWhere('nom', 'like', '%Chimie%')
            ->orWhere('nom', 'like', '%SVT%')
            ->orWhere('nom', 'like', '%Informatique%')
            ->count();

        $matieresLitteraires = Matiere::where('nom', 'like', '%Français%')
            ->orWhere('nom', 'like', '%Histoire%')
            ->orWhere('nom', 'like', '%Géographie%')
            ->orWhere('nom', 'like', '%Philosophie%')
            ->orWhere('nom', 'like', '%Langue%')
            ->count();

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES MATIÈRES');
        $this->command->info("Total matières dans la base : {$totalMatieres}");
        $this->command->info("Matières créées : {$matieresCrees}");
        $this->command->info("Matières mises à jour : {$matieresMisesAJour}");
        $this->command->info('------------------------------------');
        
        $this->command->info('📈 Répartition par coefficient :');
        foreach ($statsCoefficients as $stat) {
            $pourcentage = round(($stat->total / $totalMatieres) * 100, 1);
            $barre = str_repeat('█', $stat->total) . str_repeat('░', $totalMatieres - $stat->total);
            $this->command->line("  Coeff {$stat->coefficient} : {$stat->total} matières ({$pourcentage}%)");
        }

        $this->command->info('------------------------------------');
        $this->command->info("🧪 Matières scientifiques : {$matieresScientifiques}");
        $this->command->info("📚 Matières littéraires : {$matieresLitteraires}");
        $this->command->info("🎨 Arts et sports : " . ($totalMatieres - $matieresScientifiques - $matieresLitteraires));
        
        $this->command->info('====================================');
        $this->command->info('✅ Seeder Matiere exécuté avec succès !');
    }
}