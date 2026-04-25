<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bulletin;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;

class BulletinSeeder extends Seeder
{
    /**
     * Exactly 10 bulletins
     */
    public function run(): void
    {
        $eleves = Eleve::take(10)->get();
        $classes = Classe::take(10)->get();
        $annee = AnneeScolaire::where('active', true)->first();

        if ($eleves->isEmpty() || $classes->isEmpty() || !$annee) {
            $this->command->error('❌ Need eleves, classes, annee');
            return;
        }

        $this->command->info('🔄 Creating exactly 10 bulletins...');

        $created = 0;
        foreach ($eleves as $index => $eleve) {
            $classe = $classes[$index % $classes->count()];
            
            Bulletin::create([
                'eleve_id' => $eleve->id,
                'classe_id' => $classe->id,
                'annee_scolaire_id' => $annee->id,
                'periode' => ['Trimestre 1', 'Trimestre 2', 'Trimestre 3'][$index % 3],
                'moyenne_generale' => rand(100, 160) / 10,
                'appreciation_generale' => 'Bon travail global',
                'rang' => rand(1, 10),
                'date_bulletin' => now(),
            ]);

            $created++;
            $this->command->line("✅ {$eleve->prenom} {$eleve->nom} ({$classe->nom_complet})");
        }

        $this->command->info("✅ Exactly {$created} bulletins created!");
    }
}