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
        foreach ($enseignants as $index => $enseignant) {
            $matiere = $matieres[$index % $matieres->count()];
            $classe = $classes[$index % $classes->count()];
            
            EnseignantMatiereClasse::create([
                'enseignant_id' => $enseignant->id,
                'matiere_id' => $matiere->id,
                'classe_id' => $classe->id,
                'annee_scolaire_id' => $annee->id,
            ]);

            $created++;
            $this->command->line("✅ {$enseignant->prenom} {$enseignant->nom} → {$matiere->nom} ({$classe->nom_complet})");
        }

        $this->command->info("✅ Exactly {$created} assignments created!");
    }
}