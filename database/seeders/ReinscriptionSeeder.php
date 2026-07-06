<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reinscription;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;

class ReinscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $eleves = Eleve::all();
        $classes = Classe::all();
        $annee = AnneeScolaire::where('active', true)->first();

        if ($eleves->isEmpty() || $classes->isEmpty() || !$annee) {
            $this->command->error('❌ Élèves, classes ou année scolaire manquantes.');
            return;
        }

        $this->command->info('🔄 Création des réinscriptions pour les élèves...');

        $created = 0;
        foreach ($eleves as $index => $eleve) {
            $classe = $classes->get($index % $classes->count());
            
            Reinscription::create([
                'eleve_id' => $eleve->id,
                'classe_id' => $classe->id,
                'annee_scolaire_id' => $annee->id,
                'date_reinscription' => $annee->date_debut,
                'statut' => rand(0, 1) ? 'confirmee' : 'en_attente',
                'observation' => 'Réinscription annuelle',
            ]);

            $created++;
            $this->command->line("✅ Réinscription : {$eleve->prenom} {$eleve->nom} ↔ {$classe->nom}");
        }

        $this->command->info("✅ {$created} réinscriptions créées !");
    }
}