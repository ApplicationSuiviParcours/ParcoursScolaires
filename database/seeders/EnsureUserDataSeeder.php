<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleve;
use App\Models\Note;
use App\Models\Evaluation;
use App\Models\Absence;
use App\Models\Matiere;

class EnsureUserDataSeeder extends Seeder
{
    public function run()
    {
        $eleves = Eleve::whereNotNull('user_id')->get();
        if ($eleves->isEmpty()) return;

        $matieres = Matiere::all();
        if ($matieres->isEmpty()) return;

        foreach ($eleves as $eleve) {
            // S'assurer qu'il a une inscription active
            $inscription = $eleve->inscriptionActive;
            if (!$inscription) {
                $inscription = $eleve->inscriptions()->create([
                    'classe_id' => 1, // Fallback to first class
                    'annee_scolaire_id' => 1,
                    'date_inscription' => now(),
                    'statut' => 'inscrit',
                ]);
            }

            // Créer quelques évaluations et notes
            $classe_id = $inscription->classe_id;
            $evaluations = Evaluation::where('classe_id', $classe_id)->get();
            
            if ($evaluations->isEmpty()) {
                $ev = Evaluation::create([
                    'nom' => 'Examen Initial',
                    'matiere_id' => $matieres->first()->id,
                    'classe_id' => $classe_id,
                    'annee_scolaire_id' => 1,
                    'type' => 'Examen',
                    'date_evaluation' => now(),
                    'periode' => 'Trimestre 1',
                    'coefficient' => 1,
                ]);
                $evaluations = collect([$ev]);
            }

            foreach ($evaluations as $ev) {
                Note::firstOrCreate(
                    ['eleve_id' => $eleve->id, 'evaluation_id' => $ev->id],
                    ['note' => mt_rand(10, 18), 'observation' => 'Très bien']
                );
            }

            // Créer une évaluation future pour l'Agenda
            Evaluation::firstOrCreate(
                ['nom' => 'Examen de Fin de Trimestre', 'classe_id' => $classe_id, 'annee_scolaire_id' => 1],
                [
                    'matiere_id' => $matieres->random()->id,
                    'type' => 'Examen',
                    'date_evaluation' => now()->addDays(14),
                    'periode' => 'Trimestre 1',
                    'coefficient' => 2,
                ]
            );

            // Créer ou mettre à jour un bulletin
            $bulletin = \App\Models\Bulletin::updateOrCreate(
                ['eleve_id' => $eleve->id, 'periode' => 'Trimestre 1', 'annee_scolaire_id' => 1],
                [
                    'classe_id' => $classe_id,
                    'moyenne_generale' => mt_rand(1100, 1600) / 100,
                    'moyenne_classe' => 12.5,
                    'rang' => mt_rand(1, 5),
                    'effectif_classe' => 30,
                    'appreciation_generale' => 'Élève sérieux et appliqué.',
                    'date_bulletin' => now(),
                ]
            );

            // Attacher les notes au bulletin pour le détail
            $notes = $eleve->notes()->with('evaluation')->get();
            foreach ($notes as $note) {
                \Illuminate\Support\Facades\DB::table('bulletin_note')->updateOrInsert(
                    ['bulletin_id' => $bulletin->id, 'note_id' => $note->id],
                    [
                        'coefficient' => $note->evaluation->coefficient ?? 1,
                        'appreciation' => 'Bon travail',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            // Créer quelques absences
            Absence::firstOrCreate(
                ['eleve_id' => $eleve->id, 'date_absence' => now()->format('Y-m-d')],
                [
                    'matiere_id' => $matieres->first()->id,
                    'heure_debut' => '08:00:00',
                    'heure_fin' => '09:00:00',
                    'nombre_heures' => 1,
                    'justifiee' => false,
                    'annee_scolaire_id' => 1,
                    'motif' => 'Retard',
                ]
            );
        }
    }
}
