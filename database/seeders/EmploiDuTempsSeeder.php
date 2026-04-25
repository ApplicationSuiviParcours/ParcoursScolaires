<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmploiDuTemps;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Enseignant;
use App\Models\AnneeScolaire;
use Carbon\Carbon;

class EmploiDuTempsSeeder extends Seeder
{
    /**
     * Exactly 10 emploi du temps entries
     */
    public function run(): void
    {
        $classes = Classe::take(5)->get();
        $matieres = Matiere::take(10)->get();
        $enseignants = Enseignant::take(10)->get();
        $annee = AnneeScolaire::where('active', true)->first();

        if ($classes->isEmpty() || $matieres->isEmpty() || $enseignants->isEmpty() || !$annee) {
            $this->command->error('❌ Need classes, matieres, enseignants, annee');
            return;
        }

        $this->command->info('🔄 Creating exactly 10 emploi du temps entries...');

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        $horaires = [
            ['08:00', '09:30'],
            ['09:45', '11:15'],
            ['11:30', '13:00'],
            ['14:00', '15:30'],
            ['15:45', '17:15']
        ];

        $created = 0;
        foreach ($classes as $classe) {
            foreach (range(1, 2) as $i) {
                $horaire = $horaires[array_rand($horaires)];

                EmploiDuTemps::create([
                    'classe_id' => $classe->id,
                    'matiere_id' => $matieres->random()->id,
                    'enseignant_id' => $enseignants->random()->id,
                    'jour' => rand(1, 5),
                    'heure_debut' => $horaire[0],
                    'heure_fin' => $horaire[1],
                    'salle' => 'A' . rand(1, 5),
                    'annee_scolaire_id' => $annee->id,
                ]);

                $created++;
                if ($created >= 10) break 2;
            }
        }

        $this->command->info("✅ Exactly {$created} emploi entries created!");
    }
}