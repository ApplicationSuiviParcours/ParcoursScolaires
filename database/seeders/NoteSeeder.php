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
        $this->command->info('🔄 Initialisation des liaisons...');

        $evaluations = Evaluation::with(['classe', 'matiere'])->get();
        $eleves = Eleve::all();
        $bulletins = Bulletin::all();

        if ($evaluations->isEmpty() || $eleves->isEmpty() || $bulletins->isEmpty()) {
            $this->command->error('❌ Evaluations, élèves ou bulletins manquants.');
            return;
        }

        $this->command->info('🔄 Création des notes pour toutes les matières et évaluations (T1, T2, T3)...');

        $appreciations = [
            'Excellent travail, félicitations !', 
            'Très bon niveau, continuez ainsi.', 
            'Bon travail, élève appliqué.', 
            'Résultats satisfaisants.',
            'Peut mieux faire, des efforts sont attendus.', 
            'Moyenne juste, attention au relâchement.', 
            'Travail irrégulier, ressaisissez-vous.', 
            'Insuffisant, doit redoubler d\'efforts.'
        ];

        $created = 0;
        foreach ($evaluations as $evaluation) {
            // Récupérer les élèves de la classe
            $elevesInClass = Eleve::whereHas('inscriptions', function ($q) use ($evaluation) {
                $q->where('classe_id', $evaluation->classe_id);
            })->get();

            foreach ($elevesInClass as $eleve) {
                // Trouver le bulletin correspondant
                $bulletin = $bulletins->first(function($b) use ($eleve, $evaluation) {
                    return $b->eleve_id == $eleve->id && $b->periode == $evaluation->periode;
                });

                // Générer une note réaliste par élève
                $noteValue = $this->generateRealisticNote(
                    $evaluation->matiere->nom ?? 'Général',
                    $eleve->id
                );

                $note = Note::create([
                    'eleve_id' => $eleve->id,
                    'evaluation_id' => $evaluation->id,
                    'note' => $noteValue,
                    'observation' => $this->getAppreciation($noteValue),
                ]);

                // Lier au bulletin
                if ($bulletin) {
                    DB::table('bulletin_note')->insert([
                        'bulletin_id' => $bulletin->id,
                        'note_id' => $note->id,
                        'coefficient' => $evaluation->coefficient ?? 1,
                        'appreciation' => $note->observation,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $created++;
            }
        }

        $this->command->info("✅ {$created} notes individuelles créées !");
        
        $this->command->info('🔄 Calcul des moyennes générales des bulletins...');

        // Recalculer la moyenne générale pour chaque bulletin
        foreach ($bulletins as $bulletin) {
            $notesBulletin = DB::table('bulletin_note')
                ->join('notes', 'bulletin_note.note_id', '=', 'notes.id')
                ->where('bulletin_note.bulletin_id', $bulletin->id)
                ->get();

            $totalPoints = 0;
            $totalCoeffs = 0;

            foreach ($notesBulletin as $nb) {
                $totalPoints += $nb->note * $nb->coefficient;
                $totalCoeffs += $nb->coefficient;
            }

            $moyenneGenerale = $totalCoeffs > 0 ? round($totalPoints / $totalCoeffs, 2) : 0;

            $bulletin->update([
                'moyenne_generale' => $moyenneGenerale,
                'appreciation_generale' => $this->getBulletinAppreciation($moyenneGenerale),
            ]);
        }

        $this->command->info('🔄 Calcul des moyennes de classe et des rangs...');

        // Pour chaque classe et période, calculer la moyenne de classe et ordonner les rangs
        $classes = $bulletins->pluck('classe_id')->unique();
        $periodes = $bulletins->pluck('periode')->unique();
        $anneeScolaireId = $bulletins->first()->annee_scolaire_id;

        foreach ($classes as $classeId) {
            foreach ($periodes as $periode) {
                $bulletinsGroupe = Bulletin::where('classe_id', $classeId)
                    ->where('periode', $periode)
                    ->where('annee_scolaire_id', $anneeScolaireId)
                    ->orderBy('moyenne_generale', 'desc')
                    ->get();

                if ($bulletinsGroupe->isEmpty()) continue;

                $moyenneClasse = round($bulletinsGroupe->avg('moyenne_generale'), 2);

                $rang = 1;
                $moyennePrecedente = null;
                $rangPrecedent = 1;

                foreach ($bulletinsGroupe as $index => $b) {
                    if ($b->moyenne_generale === $moyennePrecedente) {
                        $b->rang = $rangPrecedent;
                    } else {
                        $b->rang = $index + 1;
                        $rangPrecedent = $index + 1;
                    }
                    $b->moyenne_classe = $moyenneClasse;
                    $b->save();
                    
                    $moyennePrecedente = $b->moyenne_generale;
                }
            }
        }

        $this->command->info('✅ Calculs de moyennes et rangs terminés !');
    }

    private function generateRealisticNote($matiere, $eleveId)
    {
        // Distribuer les notes de façon à ce que certains élèves soient meilleurs que d'autres
        // Élève 1 (Mouana) : Très bon (moyenne 15-18)
        // Élève 2 (Koubemba) : Moyen (moyenne 11-14)
        // Élève 3 (Serge) : Excellent (moyenne 16-19)
        // Élève 4 (Estelle) : En difficulté (moyenne 7-10)
        // Élève 5 (Patrice) : Moyen-bon (moyenne 12-15)
        
        $base = match ($eleveId % 5) {
            0 => mt_rand(140, 185) / 10,
            1 => mt_rand(110, 145) / 10,
            2 => mt_rand(160, 195) / 10,
            3 => mt_rand(70, 105) / 10,
            default => mt_rand(120, 155) / 10
        };

        // Légères variations selon la matière
        if (str_contains(strtolower($matiere), 'math')) {
            $base += (mt_rand(-15, 10) / 10);
        } elseif (str_contains(strtolower($matiere), 'eps')) {
            $base += (mt_rand(10, 20) / 10);
        }

        return round(min(max($base, 2.0), 20.0), 2);
    }

    private function getAppreciation($note)
    {
        if ($note >= 16) return 'Excellent travail, félicitations !';
        if ($note >= 14) return 'Très bon niveau, continuez ainsi.';
        if ($note >= 12) return 'Bon travail, élève appliqué.';
        if ($note >= 10) return 'Résultats satisfaisants.';
        if ($note >= 8) return 'Peut mieux faire, des efforts sont attendus.';
        if ($note >= 6) return 'Travail insuffisant, doit se ressaisir.';
        return 'En grande difficulté, un travail important est exigé.';
    }

    private function getBulletinAppreciation($moyenne)
    {
        if ($moyenne >= 16) return 'Excellent trimestre, félicitations du conseil de classe.';
        if ($moyenne >= 14) return 'Très bon trimestre, poursuivez vos efforts.';
        if ($moyenne >= 12) return 'Bon trimestre, travail sérieux.';
        if ($moyenne >= 10) return 'Trimestre convenable, élève appliqué.';
        if ($moyenne >= 8) return 'Ensemble un peu juste, renforcez votre travail.';
        return 'Trimestre insuffisant. Des efforts soutenus sont indispensables.';
    }
}