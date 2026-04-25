<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\Eleve;
use App\Models\Evaluation;
use App\Models\Bulletin;
use Illuminate\Support\Facades\DB;

class NoteSeeder extends Seeder
{
    public function run()
    {
        $evaluations = Evaluation::with(['classe', 'matiere'])->get();
        $eleves = Eleve::all();
        $bulletins = Bulletin::all();

        if ($evaluations->isEmpty() || $eleves->isEmpty()) {
            $this->command->error('❌ Manque evaluations ou eleves');
            return;
        }

        $this->command->info('🔄 Création 200+ notes (4-8/évaluation)...');

        $observations = [
            'Excellent travail', 'Bon niveau', 'Peut mieux faire', 'À surveiller',
            'Travail sérieux', 'Effort satisfaisant', 'Progression notable', 'En difficulté',
            'Très bonne participation', 'Manque de travail', 'Potentiel à développer'
        ];

        $created = 0;
        foreach ($evaluations as $evaluation) {
            $elevesInClass = Eleve::whereHas('inscriptions', function ($q) use ($evaluation) {
                $q->where('classe_id', $evaluation->classe_id);
            })->get();

            $numNotes = mt_rand(4, 8);
            $notesToCreate = min($numNotes, $elevesInClass->count());

            foreach ($elevesInClass->take($notesToCreate) as $eleve) {
                // Trouver le bulletin correspondant pour lier la note (via période)
                $bulletin = $bulletins->first(function($b) use ($eleve, $evaluation) {
                    return $b->eleve_id == $eleve->id && $b->periode == $evaluation->periode;
                });

                $noteValue = $this->generateRealisticNote(
                    ($evaluation->matiere->nom ?? 'General'), 
                    ($evaluation->classe->niveau ?? 'Moyen'), 
                    ($eleve->genre ?? 'M')
                );

                $note = Note::firstOrCreate(
                    ['eleve_id' => $eleve->id, 'evaluation_id' => $evaluation->id],
                    [
                        'note' => $noteValue,
                        'observation' => $observations[mt_rand(0, count($observations)-1)],
                    ]
                );

                // Lier la note au bulletin correspondant via la table pivot
                if ($bulletin) {
                    DB::table('bulletin_note')->updateOrInsert(
                        ['bulletin_id' => $bulletin->id, 'note_id' => $note->id],
                        [
                            'coefficient' => $evaluation->coefficient ?? 1,
                            'appreciation' => $note->observation,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }

                $created++;
            }
        }

        $this->command->info("\n✅ $created notes créées et liées aux bulletins !");
        $this->command->info('📊 ~' . round($created / max(1, $evaluations->count()), 1) . ' notes/eval');
    }

    private function generateRealisticNote($matiere, $niveau, $genre)
    {
        $base = match (true) {
            str_contains($matiere, 'Math') => mt_rand(60, 170) / 10,
            str_contains($matiere, 'Français') => mt_rand(80, 180) / 10,
            str_contains($matiere, 'EPS') => mt_rand(120, 200) / 10,
            (str_contains($niveau, 'P1') || str_contains($niveau, 'CP')) => mt_rand(90, 170) / 10,
            (str_contains($niveau, 'Terminale') || str_contains($niveau, 'Licence')) => mt_rand(50, 160) / 10,
            default => mt_rand(70, 170) / 10
        };

        if ($genre === 'F') $base += 0.5;
        return round(min(max($base, 4.0), 20.0), 2);
    }
}