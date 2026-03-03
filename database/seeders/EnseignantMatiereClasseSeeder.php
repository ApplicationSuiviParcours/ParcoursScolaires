<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\EnseignantMatiereClasse;
use App\Models\ClasseMatiere;

class EnseignantMatiereClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les données nécessaires
        $anneeScolaire = AnneeScolaire::active()->first() ?? AnneeScolaire::first();
        $enseignants = Enseignant::all();
        $classes = Classe::all();
        $matieres = Matiere::all();

        // Vérifications
        if (!$anneeScolaire) {
            $this->command->error('❌ Aucune année scolaire trouvée. Veuillez d\'abord exécuter AnneeScolaireSeeder');
            return;
        }

        if ($enseignants->isEmpty()) {
            $this->command->error('❌ Aucun enseignant trouvé. Veuillez d\'abord exécuter EnseignantSeeder');
            return;
        }

        if ($classes->isEmpty()) {
            $this->command->error('❌ Aucune classe trouvée. Veuillez d\'abord exécuter ClasseSeeder');
            return;
        }

        if ($matieres->isEmpty()) {
            $this->command->error('❌ Aucune matière trouvée. Veuillez d\'abord exécuter MatiereSeeder');
            return;
        }

        // Supprimer les anciennes affectations (optionnel)
        // EnseignantMatiereClasse::truncate();

        $this->command->info('🔄 Création des affectations enseignants-matières-classes...');

        $affectationsCrees = 0;
        $enseignantsUtilises = [];

        // Pour chaque enseignant, assigner des matières et classes
        foreach ($enseignants as $enseignant) {
            // Déterminer le nombre de classes à assigner (entre 1 et 4)
            $nombreClasses = rand(1, 4);
            
            // Sélectionner des classes aléatoires
            $classesSelectionnees = $classes->random(min($nombreClasses, $classes->count()));
            
            foreach ($classesSelectionnees as $classe) {
                // Récupérer les matières de cette classe
                $matieresDeLaClasse = $this->getMatieresPourClasse($classe);
                
                if ($matieresDeLaClasse->isEmpty()) {
                    continue;
                }

                // Sélectionner des matières que l'enseignant peut enseigner
                // Priorité aux matières correspondant à sa spécialité
                $matieresAssignables = $this->filtrerMatieresParEnseignant($matieresDeLaClasse, $enseignant);
                
                if ($matieresAssignables->isEmpty()) {
                    // Si aucune matière ne correspond, prendre une matière aléatoire
                    $matieresAssignables = $matieresDeLaClasse->take(1);
                }

                // Pour chaque matière assignée à l'enseignant pour cette classe
                foreach ($matieresAssignables as $matiere) {
                    // Vérifier si l'affectation existe déjà
                    $existe = EnseignantMatiereClasse::where('enseignant_id', $enseignant->id)
                        ->where('matiere_id', $matiere->id)
                        ->where('classe_id', $classe->id)
                        ->where('annee_scolaire_id', $anneeScolaire->id)
                        ->exists();

                    if (!$existe) {
                        EnseignantMatiereClasse::create([
                            'enseignant_id' => $enseignant->id,
                            'matiere_id' => $matiere->id,
                            'classe_id' => $classe->id,
                            'annee_scolaire_id' => $anneeScolaire->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $affectationsCrees++;
                        
                        // Enregistrer l'utilisation de l'enseignant
                        if (!isset($enseignantsUtilises[$enseignant->id])) {
                            $enseignantsUtilises[$enseignant->id] = 0;
                        }
                        $enseignantsUtilises[$enseignant->id]++;
                    }
                }
            }
        }

        // Vérifier les classes sans enseignant pour certaines matières
        $this->verifierClassesSansEnseignant($classes, $matieres, $anneeScolaire->id);

        // Afficher le résumé
        $this->afficherResume($affectationsCrees, $enseignantsUtilises);
    }

    /**
     * Récupérer les matières pour une classe
     */
    private function getMatieresPourClasse($classe)
    {
        // Via la table ClasseMatiere
        $classeMatieres = ClasseMatiere::where('classe_id', $classe->id)
            ->with('matiere')
            ->get();

        if ($classeMatieres->isNotEmpty()) {
            return $classeMatieres->pluck('matiere')->filter();
        }

        // Fallback: matières aléatoires
        return Matiere::inRandomOrder()->take(rand(5, 8))->get();
    }

    /**
     * Filtrer les matières par spécialité de l'enseignant
     */
    private function filtrerMatieresParEnseignant($matieres, $enseignant)
    {
        // Vérifier si la spécialité de l'enseignant correspond à une matière
        $matieresCorrespondantes = collect([]);
        $specialite = strtolower($enseignant->specialite ?? '');
        
        foreach ($matieres as $matiere) {
            $nomMatiere = strtolower($matiere->nom);
            
            // Correspondance approximative
            if (str_contains($nomMatiere, $specialite) || 
                str_contains($specialite, $nomMatiere) ||
                $this->correspondanceSpeciale($nomMatiere, $specialite)) {
                $matieresCorrespondantes->push($matiere);
            }
        }

        // Si des matières correspondent, les retourner, sinon retourner 1 matière aléatoire
        return $matieresCorrespondantes->isNotEmpty() 
            ? $matieresCorrespondantes 
            : $matieres->random(1);
    }

    /**
     * Correspondances spéciales pour certaines matières
     */
    private function correspondanceSpeciale(string $nomMatiere, string $specialite): bool
    {
        $correspondances = [
            'mathématiques' => ['maths', 'math', 'analyse', 'algèbre', 'géométrie'],
            'physique' => ['physique', 'mécanique', 'électricité', 'optique'],
            'chimie' => ['chimie', 'organique', 'minérale'],
            'français' => ['français', 'littérature', 'grammaire', 'orthographe'],
            'anglais' => ['anglais', 'english', 'britannique', 'américain'],
            'histoire' => ['histoire', 'géographie', 'géopolitique'],
            'sport' => ['eps', 'sport', 'éducation physique', 'gymnastique'],
            'informatique' => ['informatique', 'programmation', 'numérique', 'snt'],
        ];

        foreach ($correspondances as $matiere => $motsCles) {
            if (str_contains($nomMatiere, $matiere)) {
                foreach ($motsCles as $motCle) {
                    if (str_contains($specialite, $motCle)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Vérifier les classes sans enseignant pour certaines matières
     */
    private function verifierClassesSansEnseignant($classes, $matieres, $anneeScolaireId): void
    {
        $classesSansEnseignant = 0;
        $matieresSansEnseignant = 0;

        foreach ($classes as $classe) {
            $matieresDeLaClasse = $this->getMatieresPourClasse($classe);
            
            foreach ($matieresDeLaClasse as $matiere) {
                $affectation = EnseignantMatiereClasse::where('classe_id', $classe->id)
                    ->where('matiere_id', $matiere->id)
                    ->where('annee_scolaire_id', $anneeScolaireId)
                    ->exists();

                if (!$affectation) {
                    $classesSansEnseignant++;
                    $matieresSansEnseignant++;
                    
                    // Assigner un enseignant aléatoire pour combler le manque
                    $enseignant = Enseignant::inRandomOrder()->first();
                    
                    if ($enseignant) {
                        EnseignantMatiereClasse::create([
                            'enseignant_id' => $enseignant->id,
                            'matiere_id' => $matiere->id,
                            'classe_id' => $classe->id,
                            'annee_scolaire_id' => $anneeScolaireId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }

        if ($matieresSansEnseignant > 0) {
            $this->command->warn("⚠️ {$matieresSansEnseignant} matières sans enseignant ont été assignées automatiquement.");
        }
    }

    /**
     * Afficher un résumé des affectations créées
     */
    private function afficherResume(int $affectationsCrees, array $enseignantsUtilises): void
    {
        $totalAffectations = EnseignantMatiereClasse::count();
        $statsParClasse = EnseignantMatiereClasse::selectRaw('classe_id, count(*) as total')
            ->groupBy('classe_id')
            ->with('classe')
            ->get();

        $statsParEnseignant = EnseignantMatiereClasse::selectRaw('enseignant_id, count(*) as total')
            ->groupBy('enseignant_id')
            ->with('enseignant')
            ->get();

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES AFFECTATIONS ENSEIGNANTS-MATIÈRES-CLASSES');
        $this->command->info("Total affectations : {$totalAffectations}");
        $this->command->info("Affectations créées maintenant : {$affectationsCrees}");
        $this->command->info("Enseignants utilisés : " . count($enseignantsUtilises));
        $this->command->info('------------------------------------');
        
        // Statistiques par classe
        $this->command->info('📚 Répartition par classe :');
        foreach ($statsParClasse as $stat) {
            if ($stat->classe) {
                $this->command->line("  • {$stat->classe->nom_complet} : {$stat->total} affectations");
            }
        }

        $this->command->info('------------------------------------');
        
        // Top enseignants
        $this->command->info('👨‍🏫 Top 5 des enseignants :');
        $topEnseignants = $statsParEnseignant->sortByDesc('total')->take(5);
        foreach ($topEnseignants as $stat) {
            if ($stat->enseignant) {
                $this->command->line("  • {$stat->enseignant->nom_complet} : {$stat->total} affectations");
            }
        }
        
        $this->command->info('====================================');
        $this->command->info('✅ Seeder EnseignantMatiereClasse exécuté avec succès !');
    }
}