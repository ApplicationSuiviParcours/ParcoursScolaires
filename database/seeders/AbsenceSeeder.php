<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Absence;
use App\Models\Eleve;
use App\Models\AnneeScolaire;
use App\Models\Matiere;
use Carbon\Carbon;

class AbsenceSeeder extends Seeder
{
    public function run()
    {
        $eleves = Eleve::all();
        $annees = AnneeScolaire::all();
        $matieres = Matiere::all();

        if ($eleves->isEmpty() || $annees->isEmpty() || $matieres->isEmpty()) {
            $this->command->error('❌ Manque eleves, annees ou matieres');
            return;
        }

        $this->command->info('🔄 Création 100+ absences...');

        $motifs = ['Maladie', 'Rendez-vous medical', 'Famille', 'Transport', 'Evenement'];
        $created = 0;
        $maxAbsences = 150;

        foreach ($eleves->shuffle() as $eleve) {
            if ($created >= $maxAbsences) break;

            $annee = $annees[array_rand($annees->toArray())];
            $dateDebut = Carbon::parse($annee->date_debut);
            $dateFin = Carbon::parse($annee->date_fin);
            $nbAbsences = mt_rand(1, 8);

            for ($i = 0; $i < $nbAbsences && $created < $maxAbsences; $i++) {
                $daysDiff = $dateFin->diffInDays($dateDebut);
                $dateAbsence = $dateDebut->copy()->addDays(mt_rand(0, $daysDiff));
                $matiere = $matieres[array_rand($matieres->toArray())];

                Absence::firstOrCreate(
                    [
                        'eleve_id' => $eleve->id,
                        'date_absence' => $dateAbsence->format('Y-m-d'),
                        'matiere_id' => $matiere->id,
                    ],
                    [
                        'motif' => $motifs[array_rand($motifs)],
                        'duree_jours' => mt_rand(1, 3),
                        'heure_debut' => '08:' . str_pad(mt_rand(0, 59), 2, '0', STR_PAD_LEFT) . ':00',
                        'heure_fin' => null,
                        'justifiee' => (mt_rand(0, 100) > 30),
                        'observation' => 'Absence enregistree',
                        'annee_scolaire_id' => $annee->id,
                    ]
                );

                $created++;
            }
        }

        $this->command->info("✅ $created absences creees sans erreur!");
    }
}