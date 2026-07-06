<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bulletin;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;

class BulletinSeeder extends Seeder
{
    public function run(): void
    {
        $eleves = Eleve::all();
        $classe = Classe::where('nom', 'CE1 A')->first();
        $annee = AnneeScolaire::where('active', true)->first();

        if ($eleves->isEmpty() || !$classe || !$annee) {
            $this->command->error('❌ Élèves, classe CE1 A ou année scolaire manquante');
            return;
        }

        $this->command->info('🔄 Création des bulletins pour les 5 élèves de test (T1, T2, T3)...');

        $periodes = ['Trimestre 1', 'Trimestre 2', 'Trimestre 3'];
        $created = 0;

        foreach ($eleves as $eleve) {
            foreach ($periodes as $periode) {
                Bulletin::updateOrCreate(
                    [
                        'eleve_id' => $eleve->id,
                        'classe_id' => $classe->id,
                        'annee_scolaire_id' => $annee->id,
                        'periode' => $periode,
                    ],
                    [
                        'moyenne_generale' => 0.0, // Sera mis à jour par le NoteSeeder après calcul
                        'moyenne_classe' => 0.0,   // Mis à jour après
                        'rang' => null,            // Mis à jour après
                        'effectif_classe' => $eleves->count(),
                        'appreciation_generale' => 'Attente des notes...',
                        'date_bulletin' => now(),
                        'status' => 'publie',
                    ]
                );
                $created++;
            }
            $this->command->line("✅ Bulletins Trimestres 1, 2, 3 créés pour {$eleve->prenom} {$eleve->nom}");
        }

        $this->command->info("✅ {$created} bulletins initialisés !");
    }
}