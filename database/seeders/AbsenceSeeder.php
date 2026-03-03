<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Absence;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use Carbon\Carbon;

class AbsenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer quelques élèves, matières et années scolaires existants
        $eleves = Eleve::all();
        $matieres = Matiere::all();
        
        // CORRECTION: Utiliser 'active' au lieu de 'statut'
        $anneeScolaire = AnneeScolaire::where('active', true)->first() ?? AnneeScolaire::first();

        // Vérifier qu'il y a des données dans les tables
        if ($eleves->isEmpty() || $matieres->isEmpty() || !$anneeScolaire) {
            $this->command->warn('Veuillez d\'abord remplir les tables eleves, matieres et annees_scolaires');
            return;
        }

        // Créer des absences pour différents élèves
        $absences = [
            [
                'eleve_id' => $eleves->random()->id,
                'matiere_id' => $matieres->random()->id,
                'date_absence' => Carbon::now()->subDays(2),
                'heure_debut' => '08:00:00',
                'heure_fin' => '10:00:00',
                'motif' => 'Maladie',
                'justifiee' => true,
                'annee_scolaire_id' => $anneeScolaire->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'eleve_id' => $eleves->random()->id,
                'matiere_id' => $matieres->random()->id,
                'date_absence' => Carbon::now()->subDays(5),
                'heure_debut' => '14:00:00',
                'heure_fin' => '16:00:00',
                'motif' => 'Rendez-vous médical',
                'justifiee' => true,
                'annee_scolaire_id' => $anneeScolaire->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'eleve_id' => $eleves->random()->id,
                'matiere_id' => $matieres->random()->id,
                'date_absence' => Carbon::now()->subDays(3),
                'heure_debut' => '09:00:00',
                'heure_fin' => '12:00:00',
                'motif' => 'Retard (non justifié)',
                'justifiee' => false,
                'annee_scolaire_id' => $anneeScolaire->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'eleve_id' => $eleves->random()->id,
                'matiere_id' => $matieres->random()->id,
                'date_absence' => Carbon::now()->subDays(1),
                'heure_debut' => '10:00:00',
                'heure_fin' => '12:00:00',
                'motif' => 'Famille',
                'justifiee' => true,
                'annee_scolaire_id' => $anneeScolaire->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'eleve_id' => $eleves->random()->id,
                'matiere_id' => $matieres->random()->id,
                'date_absence' => Carbon::now()->subWeek(),
                'heure_debut' => '13:00:00',
                'heure_fin' => '17:00:00',
                'motif' => 'Absence non justifiée',
                'justifiee' => false,
                'annee_scolaire_id' => $anneeScolaire->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insérer les absences
        foreach ($absences as $absence) {
            Absence::create($absence);
        }

        // Alternative avec factory si vous avez une factory configurée
        // Absence::factory(20)->create();

        $this->command->info('Absences créées avec succès !');
    }

    /**
     * Méthode optionnelle pour créer des absences aléatoires supplémentaires
     */
    private function createRandomAbsences($count = 10)
    {
        $eleves = Eleve::all();
        $matieres = Matiere::all();
        
        // CORRECTION: Utiliser 'active' au lieu de 'statut'
        $anneeScolaire = AnneeScolaire::where('active', true)->first() ?? AnneeScolaire::first();

        for ($i = 0; $i < $count; $i++) {
            Absence::create([
                'eleve_id' => $eleves->random()->id,
                'matiere_id' => $matieres->random()->id,
                'date_absence' => Carbon::now()->subDays(rand(1, 30)),
                'heure_debut' => sprintf('%02d:00:00', rand(8, 16)),
                'heure_fin' => sprintf('%02d:00:00', rand(9, 17)),
                'motif' => $this->getRandomMotif(),
                'justifiee' => rand(0, 1),
                'annee_scolaire_id' => $anneeScolaire->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Retourne un motif aléatoire
     */
    private function getRandomMotif(): string
    {
        $motifs = [
            'Maladie',
            'Rendez-vous médical',
            'Problème familial',
            'Retard',
            'Absence non justifiée',
            'Conseil de classe',
            'Activité sportive',
            'Grève des transports',
            'Raison personnelle',
            'Examen médical'
        ];

        return $motifs[array_rand($motifs)];
    }
}