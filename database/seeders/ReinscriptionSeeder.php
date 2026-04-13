<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reinscription;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use Carbon\Carbon;

class ReinscriptionSeeder extends Seeder
{
    /**
     * Exactly 10 reinscriptions
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

        $this->command->info('🔄 Creating exactly 10 reinscriptions...');

        $created = 0;
        foreach ($eleves as $index => $eleve) {
            $classe = $classes[$index % $classes->count()];
            
            Reinscription::create([
                'eleve_id' => $eleve->id,
                'classe_id' => $classe->id,
                'annee_scolaire_id' => $annee->id,
                'date_reinscription' => $annee->date_debut,
                'statut' => rand(0, 1) ? 'confirmee' : 'en_attente',
                'observation' => 'Réinscription annuelle',
            ]);

            $created++;
            $this->command->line("✅ {$eleve->prenom} {$eleve->nom} → {$classe->nom_complet}");
        }

        $this->command->info("✅ Exactly {$created} reinscriptions created!");
    }
}