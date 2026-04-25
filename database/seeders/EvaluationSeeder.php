<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evaluation;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Enseignant;
use App\Models\AnneeScolaire;
use Carbon\Carbon;

class EvaluationSeeder extends Seeder
{
    /**
     * Create 50 evaluations: 5 per class (Devoir/Contrôle/Examen x T1/T2/T3)
     * Realistic coefficients, dates within annee, firstOrCreate to avoid duplicates
     */
    public function run(): void
    {
        $classes = Classe::all();
        $matieres = Matiere::all();
        $enseignants = Enseignant::all();
        $annee = AnneeScolaire::where('active', true)->first();

        if ($classes->isEmpty() || $matieres->isEmpty() || $enseignants->isEmpty() || !$annee) {
            $this->command->error('❌ Dependencies missing: classes, matieres, enseignants, annee active');
            return;
        }

        $this->command->info('🔄 Creating up to 50 evaluations (5/class across periods/types)...');

        $periodes = ['Trimestre 1', 'Trimestre 2', 'Trimestre 3'];
        $types = ['Devoir', 'Contrôle', 'Examen'];
        $descriptions = [
            'Évaluation de mi-parcours',
            'Contrôle continu',
            'Examen trimestriel',
            'Devoir maison',
            'Test de connaissances',
            'Évaluation sommative',
            'Quiz hebdomadaire',
            'Travail pratique',
            'Interrogation orale',
            'Projet de classe'
        ];

        $created = 0;
        $skipped = 0;

        $assignments = \App\Models\EnseignantMatiereClasse::all();
        if ($assignments->isEmpty()) {
            $this->command->error('❌ No assignments found. Run EnseignantMatiereClasseSeeder first.');
            return;
        }

        foreach ($assignments as $assignment) {
            foreach ($periodes as $periode) {
                foreach ($types as $type) {
                    if ($created >= 100) break 3; // Increase limit to 100 total

                    $dateStart = Carbon::parse($annee->date_debut);
                    $dateEval = $dateStart->copy()->addMonths($periode === 'Trimestre 1' ? 1 : ($periode === 'Trimestre 2' ? 4 : 7))->addDays(rand(0, 60));

                    $evaluation = Evaluation::updateOrCreate(
                        [
                            'enseignant_id' => $assignment->enseignant_id,
                            'classe_id' => $assignment->classe_id,
                            'matiere_id' => $assignment->matiere_id,
                            'annee_scolaire_id' => $annee->id,
                            'type' => $type,
                            'periode' => $periode,
                        ],
                        [
                            'nom' => "{$type} de {$assignment->matiere->nom} ({$periode})",
                            'description' => $descriptions[array_rand($descriptions)],
                            'date_evaluation' => $dateEval->format('Y-m-d'),
                            'coefficient' => $type === 'Examen' ? rand(3,5) : rand(1,2),
                            'bareme' => 20,
                        ]
                    );

                    if ($evaluation->wasRecentlyCreated) {
                        $created++;
                        $this->command->line("✅ {$evaluation->nom} | {$assignment->classe->nom} | {$assignment->enseignant->nom}");
                    } else {
                        $skipped++;
                    }
                }
            }
        }

        $this->command->info("\n📊 SUMMARY: {$created} created, {$skipped} skipped (existing)");
        $this->command->info("✅ EvaluationSeeder completed without errors!");
    }
}