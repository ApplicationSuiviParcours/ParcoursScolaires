<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleve;
use App\Models\ParentEleve;
use App\Models\EleveParent;
use Illuminate\Support\Facades\DB;

class EleveParentSeeder extends Seeder
{
    /**
     * Types de liens parentaux possibles
     */
    private array $liensParentaux = [
        'pere' => 0.25,      // 25% des relations
        'mere' => 0.35,      // 35% des relations
        'tuteur' => 0.15,    // 15% des relations
        'grand_parent' => 0.10, // 10% des relations
        'oncle' => 0.05,     // 5% des relations
        'tante' => 0.05,     // 5% des relations
        'frere' => 0.03,     // 3% des relations
        'soeur' => 0.02,     // 2% des relations
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les élèves et parents
        $eleves = Eleve::all();
        $parents = ParentEleve::all();

        if ($eleves->isEmpty()) {
            $this->command->error('❌ Aucun élève trouvé. Veuillez d\'abord exécuter EleveSeeder');
            return;
        }

        if ($parents->isEmpty()) {
            $this->command->error('❌ Aucun parent trouvé. Veuillez d\'abord exécuter ParentEleveSeeder');
            return;
        }

        // Supprimer les anciennes relations (optionnel)
        // EleveParent::truncate();

        $this->command->info('🔄 Création des relations élèves-parents...');

        $relationsCrees = 0;
        $elevesSansParent = 0;

        foreach ($eleves as $eleve) {
            // Décider du nombre de parents pour cet élève (0, 1 ou 2)
            $nombreParents = $this->determinerNombreParents($eleve);
            
            if ($nombreParents === 0) {
                $elevesSansParent++;
                continue;
            }

            // Sélectionner des parents aléatoires non déjà associés
            $parentsDisponibles = $parents->filter(function($parent) use ($eleve) {
                return !EleveParent::where('eleve_id', $eleve->id)
                                   ->where('parent_eleve_id', $parent->id)
                                   ->exists();
            });

            if ($parentsDisponibles->count() < $nombreParents) {
                $this->command->warn("⚠️ Pas assez de parents disponibles pour l'élève {$eleve->nom_complet}");
                continue;
            }

            $parentsSelectionnes = $parentsDisponibles->random($nombreParents);

            foreach ($parentsSelectionnes as $parent) {
                // Déterminer le lien parental approprié
                $lienParental = $this->determinerLienParental($parent, $eleve);

                // Créer la relation
                EleveParent::create([
                    'eleve_id' => $eleve->id,
                    'parent_eleve_id' => $parent->id,
                    'lien_parental' => $lienParental,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $relationsCrees++;
            }
        }

        // Créer des relations supplémentaires (frères/soeurs dans la même famille)
        $relationsSupplementaires = $this->creerRelationsFratrie($eleves, $parents);

        // Afficher le résumé
        $this->afficherResume($relationsCrees + $relationsSupplementaires, $eleves->count(), $elevesSansParent);
    }

    /**
     * Déterminer le nombre de parents pour un élève
     */
    private function determinerNombreParents($eleve): int
    {
        // Logique probabiliste
        $rand = rand(1, 100);

        // 10% des élèves n'ont pas de parent dans le système
        if ($rand <= 10) {
            return 0;
        }
        
        // 70% des élèves ont 1 parent
        if ($rand <= 80) {
            return 1;
        }
        
        // 20% des élèves ont 2 parents
        return 2;
    }

    /**
     * Déterminer le lien parental en fonction du genre du parent et de l'élève
     */
    private function determinerLienParental($parent, $eleve): string
    {
        // Distribution probabiliste des liens
        $rand = rand(1, 100);
        $cumul = 0;

        foreach ($this->liensParentaux as $lien => $probabilite) {
            $cumul += $probabilite * 100;
            if ($rand <= $cumul) {
                return $lien;
            }
        }

        // Par défaut, essayer de deviner le lien
        if ($parent->genre === 'F') {
            return 'mere';
        } elseif ($parent->genre === 'M') {
            return 'pere';
        }

        return 'tuteur';
    }

    /**
     * Créer des relations de fratrie (élèves qui partagent les mêmes parents)
     */
    private function creerRelationsFratrie($eleves, $parents): int
    {
        $relationsCrees = 0;
        
        // Grouper les élèves par nom de famille (simulation de familles)
        $familles = $eleves->groupBy('nom');

        foreach ($familles as $nomFamille => $membresFamille) {
            // Ne traiter que les familles avec au moins 2 enfants
            if ($membresFamille->count() < 2) {
                continue;
            }

            // Chercher des parents avec le même nom
            $parentsFamille = $parents->filter(function($parent) use ($nomFamille) {
                return $parent->nom === $nomFamille;
            });

            if ($parentsFamille->isEmpty()) {
                continue;
            }

            // Pour chaque parent de la famille, le lier à tous les enfants
            foreach ($parentsFamille as $parent) {
                foreach ($membresFamille as $eleve) {
                    // Vérifier si la relation n'existe pas déjà
                    $existe = EleveParent::where('eleve_id', $eleve->id)
                                        ->where('parent_eleve_id', $parent->id)
                                        ->exists();

                    if (!$existe) {
                        EleveParent::create([
                            'eleve_id' => $eleve->id,
                            'parent_eleve_id' => $parent->id,
                            'lien_parental' => $parent->genre === 'F' ? 'mere' : 'pere',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $relationsCrees++;
                    }
                }
            }
        }

        return $relationsCrees;
    }

    /**
     * Afficher un résumé des relations créées
     */
    private function afficherResume(int $relationsCrees, int $totalEleves, int $elevesSansParent): void
    {
        $stats = EleveParent::getStats();

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES RELATIONS ÉLÈVES-PARENTS');
        $this->command->info("Total relations créées : {$relationsCrees}");
        $this->command->info("Total élèves : {$totalEleves}");
        $this->command->info("Élèves sans parent : {$elevesSansParent}");
        $this->command->info("Élèves avec au moins un parent : " . ($totalEleves - $elevesSansParent));
        $this->command->info('------------------------------------');
        $this->command->info('📈 Statistiques globales :');
        $this->command->info("  • Total relations : {$stats['total_relations']}");
        $this->command->info("  • Élèves concernés : {$stats['total_eleves_concernes']}");
        $this->command->info("  • Parents concernés : {$stats['total_parents_concernes']}");
        $this->command->info('------------------------------------');
        $this->command->info('🔗 Répartition par lien parental :');
        
        foreach ($stats['repartition_liens'] as $lien) {
            $libelle = (new EleveParent())->getLienParentalLibelleAttribute($lien->lien_parental);
            $pourcentage = round(($lien->total / $stats['total_relations']) * 100, 1);
            $this->command->line("  • {$libelle} : {$lien->total} ({$pourcentage}%)");
        }
        
        $this->command->info('====================================');
        $this->command->info('✅ Seeder EleveParent exécuté avec succès !');
    }
}