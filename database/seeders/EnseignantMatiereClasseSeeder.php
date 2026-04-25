<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EnseignantMatiereClasse;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\AnneeScolaire;

class EnseignantMatiereClasseSeeder extends Seeder
{
    /**
     * Exactly 10 assignments
     */
    public function run(): void
    {
        $enseignants = Enseignant::take(10)->get();
        $matieres = Matiere::take(10)->get();
        $classes = Classe::take(10)->get();
        $annee = AnneeScolaire::where('active', true)->first();

        if ($enseignants->isEmpty() || $matieres->isEmpty() || $classes->isEmpty() || !$annee) {
            $this->command->error('❌ Need enseignants, matieres, classes, annee');
            return;
        }

        $this->command->info('🔄 Creating exactly 10 enseignant-matiere-classe assignments...');

        $created = 0;
        foreach ($enseignants as $enseignant) {
            // Assign 2 distinct random assignments
            $randomMatieres = $matieres->random(2);
            $randomClasses = $classes->random(2);

            foreach ([0, 1] as $i) {
                EnseignantMatiereClasse::updateOrCreate(
                    [
                        'enseignant_id' => $enseignant->id,
                        'matiere_id' => $randomMatieres[$i]->id,
                        'classe_id' => $randomClasses[$i]->id,
                    ],
                    ['annee_scolaire_id' => $annee->id]
                );
                $created++;
                $this->command->line("✅ {$enseignant->prenom} {$enseignant->nom} → {$randomMatieres[$i]->nom} ({$randomClasses[$i]->nom_complet})");
            }
        }

        $this->command->info("✅ Exactly {$created} assignments created!");
    }
}