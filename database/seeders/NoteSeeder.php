<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use App\Models\Eleve;
use App\Models\Evaluation;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Bulletin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class NoteSeeder extends Seeder
{
    /**
     * Types d'observations pour les notes
     */
    private array $observations = [
        'Très bon travail',
        'Bon travail',
        'Travail satisfaisant',
        'Peut mieux faire',
        'Insuffisant',
        'À revoir',
        'Excellent',
        'Encourageant',
        'Des efforts à fournir',
        'En progrès',
        'À consolider',
        'Maîtrise insuffisante',
        'Maîtrise fragile',
        'Maîtrise satisfaisante',
        'Très bonne maîtrise',
        'Excellent travail, félicitations',
        null,
        null,
        null, // Plus de chances d'avoir pas d'observation
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les données nécessaires
        $eleves = Eleve::all();
        $evaluations = Evaluation::all();

        // Vérifications
        if ($eleves->isEmpty()) {
            $this->command->error('❌ Aucun élève trouvé. Veuillez d\'abord exécuter EleveSeeder');
            return;
        }

        if ($evaluations->isEmpty()) {
            $this->command->error('❌ Aucune évaluation trouvée. Veuillez d\'abord exécuter EvaluationSeeder');
            return;
        }

        $this->command->info('🔄 Création des notes...');

        $notesCrees = 0;
        $evaluationsSansNotes = 0;
        $notesParEvaluation = [];

        foreach ($evaluations as $evaluation) {
            // Récupérer les élèves de la classe concernée par l'évaluation
            $elevesDeLaClasse = $this->getElevesPourEvaluation($evaluation, $eleves);
            
            if ($elevesDeLaClasse->isEmpty()) {
                $this->command->warn("  ⚠️ Aucun élève trouvé pour l'évaluation '{$evaluation->nom}' (classe {$evaluation->classe->nom_complet})");
                $evaluationsSansNotes++;
                continue;
            }

            $notesPourCetteEval = 0;
            $bareme = $evaluation->bareme ?? 20;

            foreach ($elevesDeLaClasse as $eleve) {
                // Vérifier si une note existe déjà pour cet élève et cette évaluation
                $noteExistante = Note::where('eleve_id', $eleve->id)
                    ->where('evaluation_id', $evaluation->id)
                    ->exists();

                if ($noteExistante) {
                    continue;
                }

                // Générer une note réaliste
                $note = $this->genererNoteRealiste($bareme);
                
                // Générer une observation
                $observation = $this->genererObservation($note, $bareme);

                // Déterminer la date de saisie (après la date de l'évaluation)
                $dateSaisie = $this->genererDateSaisie($evaluation->date_evaluation);

                // Créer la note
                $noteModel = Note::create([
                    'eleve_id' => $eleve->id,
                    'evaluation_id' => $evaluation->id,
                    'note' => $note,
                    'observation' => $observation,
                    'created_at' => $dateSaisie,
                    'updated_at' => $dateSaisie,
                ]);

                // Associer la note à un bulletin si nécessaire (et si la relation existe)
                $this->associerNoteABulletin($noteModel, $evaluation, $eleve);

                $notesCrees++;
                $notesPourCetteEval++;
            }

            $notesParEvaluation[$evaluation->id] = $notesPourCetteEval;

            if ($notesPourCetteEval > 0) {
                $this->command->line("  ✅ {$notesPourCetteEval} notes pour '{$evaluation->nom}'");
            }
        }

        // Créer des notes pour les bulletins (si la relation existe)
        $notesBulletin = $this->creerNotesPourBulletins();
        $notesCrees += $notesBulletin;

        // Afficher le résumé
        $this->afficherResume($notesCrees, $evaluationsSansNotes, $notesParEvaluation);
    }

    /**
     * Récupérer les élèves pour une évaluation
     */
    private function getElevesPourEvaluation($evaluation, $tousLesEleves)
    {
        // Filtrer les élèves par classe (via les inscriptions actives)
        return $tousLesEleves->filter(function($eleve) use ($evaluation) {
            // Vérifier si l'élève est dans la classe de l'évaluation
            $inscriptionActive = $eleve->inscriptions()
                ->where('classe_id', $evaluation->classe_id)
                ->where('statut', true)
                ->exists();
            
            return $inscriptionActive;
        });
    }

    /**
     * Générer une note réaliste selon une distribution normale
     */
    private function genererNoteRealiste($bareme): float
    {
        // Distribution normale approximative
        $rand = rand(1, 100);
        
        if ($rand <= 5) { // 5% de très mauvaises notes
            $note = rand(0, 50) / 10; // 0-5
        } elseif ($rand <= 20) { // 15% de mauvaises notes
            $note = rand(50, 90) / 10; // 5-9
        } elseif ($rand <= 65) { // 45% de notes moyennes
            $note = rand(90, 130) / 10; // 9-13
        } elseif ($rand <= 90) { // 25% de bonnes notes
            $note = rand(130, 170) / 10; // 13-17
        } else { // 10% d'excellentes notes
            $note = rand(170, 200) / 10; // 17-20
        }

        // Ajuster au barème si différent de 20
        if ($bareme != 20) {
            $note = ($note / 20) * $bareme;
        }

        return round($note, 1);
    }

    /**
     * Générer une observation en fonction de la note
     */
    private function genererObservation($note, $bareme): ?string
    {
        // 40% de chance de ne pas avoir d'observation
        if (rand(0, 100) <= 40) {
            return null;
        }

        $pourcentage = ($note / $bareme) * 100;

        if ($pourcentage >= 90) {
            $observations = ['Excellent travail', 'Félicitations', 'Très bonne maîtrise', 'Excellent'];
        } elseif ($pourcentage >= 80) {
            $observations = ['Très bon travail', 'Très bien', 'Maîtrise très satisfaisante'];
        } elseif ($pourcentage >= 70) {
            $observations = ['Bon travail', 'Bien', 'Maîtrise satisfaisante'];
        } elseif ($pourcentage >= 60) {
            $observations = ['Travail satisfaisant', 'Assez bien', 'Quelques lacunes'];
        } elseif ($pourcentage >= 50) {
            $observations = ['Peut mieux faire', 'Insuffisant', 'Des efforts à fournir'];
        } elseif ($pourcentage >= 40) {
            $observations = ['Insuffisant', 'À revoir', 'Travail insuffisant'];
        } else {
            $observations = ['Très insuffisant', 'Résultats très faibles', 'Remise à niveau nécessaire'];
        }

        return $observations[array_rand($observations)];
    }

    /**
     * Générer une date de saisie (après l'évaluation)
     */
    private function genererDateSaisie($dateEvaluation): Carbon
    {
        $dateEval = Carbon::parse($dateEvaluation);
        $now = Carbon::now();

        // Si la date d'évaluation est dans le futur, utiliser la date actuelle
        if ($dateEval->isFuture()) {
            return $now;
        }

        // Sinon, choisir une date entre l'évaluation et aujourd'hui (ou 5 jours après max)
        $dateMax = $dateEval->copy()->addDays(10)->min($now);
        
        return Carbon::createFromTimestamp(
            rand($dateEval->timestamp, $dateMax->timestamp)
        );
    }

    /**
     * Associer une note à un bulletin (si la relation existe)
     */
    private function associerNoteABulletin($note, $evaluation, $eleve): void
    {
        // Vérifier si la table bulletin_note existe
        if (!Schema::hasTable('bulletin_note')) {
            return;
        }

        // Récupérer le bulletin correspondant à l'élève, la période et l'année
        $bulletin = Bulletin::where('eleve_id', $eleve->id)
            ->where('periode', $evaluation->periode)
            ->where('annee_scolaire_id', $evaluation->annee_scolaire_id)
            ->first();

        if ($bulletin) {
            // Vérifier si la note est déjà associée
            $existe = DB::table('bulletin_note')
                ->where('bulletin_id', $bulletin->id)
                ->where('note_id', $note->id)
                ->exists();

            if (!$existe) {
                DB::table('bulletin_note')->insert([
                    'bulletin_id' => $bulletin->id,
                    'note_id' => $note->id,
                    'coefficient' => $evaluation->coefficient,
                    'appreciation' => $note->observation ?? $note->appreciation_auto,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Créer des notes pour les bulletins (si la relation bulletin_id existe)
     */
    private function creerNotesPourBulletins(): int
    {
        // Vérifier si le champ bulletin_id existe dans la table notes
        if (!Schema::hasColumn('notes', 'bulletin_id')) {
            return 0;
        }

        $notesCrees = 0;
        $bulletins = Bulletin::all();

        foreach ($bulletins as $bulletin) {
            // Récupérer les évaluations pour cette période et cette classe
            $evaluations = Evaluation::where('classe_id', $bulletin->classe_id)
                ->where('periode', $bulletin->periode)
                ->where('annee_scolaire_id', $bulletin->annee_scolaire_id)
                ->get();

            foreach ($evaluations as $evaluation) {
                // Vérifier si une note existe déjà pour cet élève et cette évaluation
                $noteExistante = Note::where('eleve_id', $bulletin->eleve_id)
                    ->where('evaluation_id', $evaluation->id)
                    ->first();

                if (!$noteExistante) {
                    // Générer une note
                    $note = $this->genererNoteRealiste($evaluation->bareme ?? 20);
                    $observation = $this->genererObservation($note, $evaluation->bareme ?? 20);

                    // Créer la note avec bulletin_id
                    Note::create([
                        'eleve_id' => $bulletin->eleve_id,
                        'evaluation_id' => $evaluation->id,
                        'note' => $note,
                        'observation' => $observation,
                        'bulletin_id' => $bulletin->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $notesCrees++;
                }
            }
        }

        return $notesCrees;
    }

    /**
     * Afficher un résumé des notes créées
     */
    private function afficherResume(int $notesCrees, int $evaluationsSansNotes, array $notesParEvaluation): void
    {
        $totalNotes = Note::count();
        $statsReussite = Note::selectRaw('
            SUM(CASE WHEN note >= 10 THEN 1 ELSE 0 END) as reussites,
            SUM(CASE WHEN note < 10 THEN 1 ELSE 0 END) as echecs,
            AVG(note) as moyenne_generale
        ')->first();

        $notesParMatiere = Note::selectRaw('matieres.nom, COUNT(*) as total, AVG(notes.note) as moyenne')
            ->join('evaluations', 'notes.evaluation_id', '=', 'evaluations.id')
            ->join('matieres', 'evaluations.matiere_id', '=', 'matieres.id')
            ->groupBy('matieres.id', 'matieres.nom')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES NOTES');
        $this->command->info("Total notes dans la base : {$totalNotes}");
        $this->command->info("Notes créées maintenant : {$notesCrees}");
        $this->command->info("Évaluations sans notes : {$evaluationsSansNotes}");
        $this->command->info('------------------------------------');
        
        $this->command->info('📈 Statistiques générales :');
        $this->command->line("  • Notes de réussite (>=10) : {$statsReussite->reussites}");
        $this->command->line("  • Notes d'échec (<10) : {$statsReussite->echecs}");
        $this->command->line("  • Moyenne générale : " . round($statsReussite->moyenne_generale ?? 0, 2) . "/20");
        $this->command->line("  • Taux de réussite : " . round(($statsReussite->reussites / max($totalNotes, 1)) * 100, 1) . "%");

        if ($notesParMatiere->isNotEmpty()) {
            $this->command->info('------------------------------------');
            $this->command->info('📚 Top 5 matières par nombre de notes :');
            foreach ($notesParMatiere as $stat) {
                $this->command->line("  • {$stat->nom} : {$stat->total} notes (moy. {$stat->moyenne}/20)");
            }
        }

        $this->command->info('====================================');
        $this->command->info('✅ Seeder Note exécuté avec succès !');
    }
}