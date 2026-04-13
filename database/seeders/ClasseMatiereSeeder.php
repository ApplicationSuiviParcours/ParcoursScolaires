<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClasseMatiere;
use App\Models\Classe;
use App\Models\Matiere;

class ClasseMatiereSeeder extends Seeder
{
    public function run(): void
    {
        $classes = Classe::take(10)->get();
        $matieres = Matiere::take(10)->get();

        if ($classes->isEmpty() || $matieres->isEmpty()) {
            $this->command->error('❌ Need 10 classes and matieres first');
            return;
        }

        $this->command->info('🔄 Creating exactly 10 classe-matiere associations...');

        $created = 0;
        foreach ($classes as $index => $classe) {
            $matiere = $matieres[$index % $matieres->count()];
            
            if (!ClasseMatiere::where('classe_id', $classe->id)->where('matiere_id', $matiere->id)->exists()) {
                ClasseMatiere::create([
                    'classe_id' => $classe->id,
                    'matiere_id' => $matiere->id,
                    'coefficient' => rand(2, 5),
                ]);
                $created++;
                $this->command->line("✅ {$classe->nom_complet} - {$matiere->nom} (coeff " . rand(2,5) . ")");
            }
        }

        $this->command->info("✅ Exactly {$created} associations created!");
    }
}