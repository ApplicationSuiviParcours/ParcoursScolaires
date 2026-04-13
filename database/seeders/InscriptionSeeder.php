<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inscription;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use Carbon\Carbon;

class InscriptionSeeder extends Seeder
{
    /**
     * Exactly 10 inscriptions
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

        $this->command->info('🔄 Creating exactly 10 inscriptions...');

        $created = 0;
        foreach ($eleves as $index => $eleve) {
            $classe = $classes[$index % $classes->count()];
            
            Inscription::create([
                'eleve_id' => $eleve->id,
                'classe_id' => $classe->id,
                'annee_scolaire_id' => $annee->id,
                'date_inscription' => $annee->date_debut,
                'statut' => true,
                'observation' => 'Inscription normale',
            ]);

            $created++;
            $this->command->line("✅ {$eleve->prenom} {$eleve->nom} → {$classe->nom_complet}");
        }

        $this->command->info("✅ Exactly {$created} inscriptions created!");
    }
}