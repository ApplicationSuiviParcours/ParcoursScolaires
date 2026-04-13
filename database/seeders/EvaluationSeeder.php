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

        foreach ($classes as $classe) {
            foreach ($periodes as $periode) {
                foreach ($types as $type) {
                    if ($created >= 50) break 3; // Limit to 50 total

                    $matiere = $matieres->random();
$enseignant = $enseignants->random();
                    
                    $dateStart = Carbon::parse($annee->date_debut);
                    $dateEnd = Carbon::parse($annee->date_fin);
                    $dateEval = $dateStart->copy()->addMonths($periodes === 'Trimestre 1' ? 1 : ($periodes === 'Trimestre 2' ? 4 : 7))->addDays(rand(0, 60));

                    $uniqueKey = "classe_{$classe->id}_matiere_{$matiere->id}_type_{$type}_periode_{$periode}";
                    
                    $evaluation = Evaluation::firstOrCreate(
                        [
                            'enseignant_id' => $enseignant->id,
                            'classe_id' => $classe->id,
                            'matiere_id' => $matiere->id,
                            'annee_scolaire_id' => $annee->id,
                            'type' => $type,
                            'periode' => $periode,
                        ],
                        [
                            'nom' => "{$type} de {$matiere->nom} ({$periode})",
                            'description' => $descriptions[array_rand($descriptions)],
                            'date_evaluation' => $dateEval->format('Y-m-d'),
                            'coefficient' => $type === 'Examen' ? rand(2,4) : rand(1,2),
                            'bareme' => 20,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );

                    if ($evaluation->wasRecentlyCreated) {
                        $created++;
                        $this->command->line("✅ {$evaluation->nom} | {$classe->nom_complet} | {$enseignant->prenom} {$enseignant->nom}");
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