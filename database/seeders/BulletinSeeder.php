<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bulletin;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Note;
use App\Models\Matiere;
use App\Models\Evaluation;
use Carbon\Carbon;

class BulletinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les données nécessaires
        $eleves = Eleve::all();
        $classes = Classe::all();
        $anneeScolaire = AnneeScolaire::active()->first() ?? AnneeScolaire::first();
        $matieres = Matiere::all();

        // Vérification des données
        if ($eleves->isEmpty() || $classes->isEmpty() || !$anneeScolaire || $matieres->isEmpty()) {
            $this->command->warn('Veuillez d\'abord remplir les tables: eleves, classes, annees_scolaires, matieres');
            return;
        }

        // Périodes de bulletin
        $periodes = ['Trimestre 1', 'Trimestre 2', 'Trimestre 3', 'Semestre 1', 'Semestre 2'];

        // Créer des bulletins pour chaque élève de chaque classe
        foreach ($classes as $classe) {
            $elevesDeLaClasse = $eleves->where('classe_id', $classe->id);
            
            if ($elevesDeLaClasse->isEmpty()) {
                continue;
            }

            // Pour chaque période
            foreach ($periodes as $index => $periode) {
                // Date du bulletin (progressive dans l'année)
                $dateBulletin = Carbon::parse($anneeScolaire->date_debut)
                    ->addMonths(($index + 1) * 3)
                    ->format('Y-m-d');

                // Créer les bulletins pour tous les élèves de la classe
                $bulletins = [];
                foreach ($elevesDeLaClasse as $eleve) {
                    // Calculer une moyenne aléatoire (entre 0 et 20)
                    $moyenne = round(rand(50, 190) / 10, 2); // Entre 5.0 et 19.0
                    
                    $bulletins[] = [
                        'eleve_id' => $eleve->id,
                        'classe_id' => $classe->id,
                        'annee_scolaire_id' => $anneeScolaire->id,
                        'periode' => $periode,
                        'moyenne_generale' => $moyenne,
                        'rang' => null, // Sera calculé après
                        'effectif_classe' => $elevesDeLaClasse->count(),
                        'appreciation' => $this->genererAppreciation($moyenne),
                        'date_bulletin' => $dateBulletin,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Insérer les bulletins
                foreach ($bulletins as $bulletinData) {
                    $bulletin = Bulletin::create($bulletinData);
                    
                    // Si vous utilisez la relation avec les notes
                    if (method_exists($bulletin, 'notesBulletin') && $matieres->isNotEmpty()) {
                        $this->attacherNotesAuBulletin($bulletin, $matieres);
                    }
                }

                // Calculer et mettre à jour les rangs pour cette période
                $this->calculerRangs($classe->id, $anneeScolaire->id, $periode);
            }
        }

        $this->command->info('✅ Bulletins créés avec succès !');
    }

    /**
     * Calculer et mettre à jour les rangs pour une classe/période
     */
    private function calculerRangs($classeId, $anneeScolaireId, $periode): void
    {
        $bulletins = Bulletin::where('classe_id', $classeId)
            ->where('annee_scolaire_id', $anneeScolaireId)
            ->where('periode', $periode)
            ->orderBy('moyenne_generale', 'desc')
            ->get();

        $rang = 1;
        foreach ($bulletins as $bulletin) {
            $bulletin->update(['rang' => $rang]);
            $rang++;
        }
    }

    /**
     * Attacher des notes au bulletin (version avec table pivot bulletin_note)
     */
    private function attacherNotesAuBulletin($bulletin, $matieres): void
    {
        // Récupérer ou créer des évaluations pour cet élève
        foreach ($matieres->random(rand(5, 8)) as $matiere) {
            // Créer une évaluation si elle n'existe pas
            $evaluation = Evaluation::firstOrCreate([
                'titre' => 'Évaluation ' . $matiere->nom,
                'matiere_id' => $matiere->id,
                'classe_id' => $bulletin->classe_id,
                'annee_scolaire_id' => $bulletin->annee_scolaire_id,
                'date_evaluation' => Carbon::parse($bulletin->date_bulletin)->subDays(rand(5, 15)),
                'coefficient' => rand(1, 3),
            ], [
                'type_evaluation' => 'Devoir',
                'description' => 'Évaluation pour le bulletin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Créer une note pour cette évaluation
            $note = Note::create([
                'eleve_id' => $bulletin->eleve_id,
                'evaluation_id' => $evaluation->id,
                'note' => rand(50, 200) / 10, // Note entre 5.0 et 20.0
                'appreciation' => $this->genererAppreciationNote(),
                'date_saisie' => Carbon::parse($bulletin->date_bulletin)->subDays(rand(1, 5)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Attacher la note au bulletin avec pivot
            $bulletin->notesBulletin()->attach($note->id, [
                'coefficient' => $evaluation->coefficient,
                'appreciation' => $note->appreciation,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Recalculer la moyenne générale du bulletin
        $bulletin->moyenne_generale = $bulletin->calculerMoyenneGenerale();
        $bulletin->save();
    }

    /**
     * Générer une appréciation en fonction de la moyenne
     */
    private function genererAppreciation($moyenne): string
    {
        if ($moyenne >= 16) {
            return 'Excellent travail, félicitations ! Continuez ainsi.';
        } elseif ($moyenne >= 14) {
            return 'Très bon trimestre, de très bons résultats.';
        } elseif ($moyenne >= 12) {
            return 'Bon travail dans l\'ensemble, quelques efforts à maintenir.';
        } elseif ($moyenne >= 10) {
            return 'Résultats satisfaisants, peut mieux faire avec plus de travail.';
        } elseif ($moyenne >= 8) {
            return 'Résultats insuffisants, des efforts sont nécessaires.';
        } else {
            return 'Travail très insuffisant, une mobilisation importante est requise.';
        }
    }

    /**
     * Générer une appréciation aléatoire pour une note
     */
    private function genererAppreciationNote(): string
    {
        $appreciations = [
            'Très bon travail',
            'Bon travail',
            'Travail satisfaisant',
            'Peut mieux faire',
            'Insuffisant',
            'À revoir',
            'Excellent',
            'Encourageant',
        ];

        return $appreciations[array_rand($appreciations)];
    }
}