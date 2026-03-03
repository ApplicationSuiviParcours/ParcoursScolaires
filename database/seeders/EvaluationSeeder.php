<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evaluation;
use App\Models\Enseignant;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use App\Models\Note;
use App\Models\Eleve;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EvaluationSeeder extends Seeder
{
    /**
     * Types d'évaluations disponibles
     */
    private array $typesEvaluation = [
        'Devoir',
        'Examen',
        'Interrogation écrite',
        'Interrogation orale',
        'Projet',
        'TP',
        'Rapport',
        'Présentation',
        'Composition',
        'Test',
        'Quiz',
        'Exposé',
    ];

    /**
     * Périodes scolaires
     */
    private array $periodes = [
        'Trimestre 1',
        'Trimestre 2',
        'Trimestre 3',
        'Semestre 1',
        'Semestre 2',
    ];

    /**
     * Noms d'évaluations par matière
     */
    private array $nomsParMatiere = [
        'Mathématiques' => [
            'Contrôle sur les équations',
            'Devoir sur les fonctions',
            'Interrogation de géométrie',
            'Test de calcul mental',
            'Examen de trigonométrie',
            'Devoir sur les probabilités',
            'Contrôle de statistiques',
            'Évaluation sur les vecteurs',
        ],
        'Français' => [
            'Dictée',
            'Rédaction',
            'Analyse de texte',
            'Étude de l\'œuvre',
            'Interrogation de grammaire',
            'Contrôle de conjugaison',
            'Dissertation',
            'Commentaire composé',
        ],
        'Anglais' => [
            'Test de vocabulaire',
            'Compréhension orale',
            'Expression écrite',
            'Interrogation de grammaire',
            'Compréhension de texte',
            'Test de conjugaison',
        ],
        'Physique-Chimie' => [
            'TP noté',
            'Contrôle sur l\'électricité',
            'Devoir de mécanique',
            'Interrogation de chimie organique',
            'Évaluation sur l\'optique',
            'Compte-rendu de TP',
        ],
        'SVT' => [
            'Interrogation de biologie',
            'Contrôle sur la génétique',
            'TP noté',
            'Devoir sur l\'écologie',
            'Évaluation sur le corps humain',
            'Compte-rendu d\'observation',
        ],
        'Histoire-Géo' => [
            'Contrôle de repères chronologiques',
            'Analyse de document',
            'Interrogation de cartographie',
            'Devoir sur la géopolitique',
            'Évaluation sur les institutions',
            'Exposé noté',
        ],
        'Philosophie' => [
            'Dissertation',
            'Explication de texte',
            'Interrogation de notions',
            'Contrôle sur les auteurs',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les données nécessaires
        $anneeScolaire = AnneeScolaire::active()->first() ?? AnneeScolaire::first();
        $enseignants = Enseignant::all();
        $classes = Classe::all();
        $matieres = Matiere::all();

        // Vérifications
        if (!$anneeScolaire) {
            $this->command->error('❌ Aucune année scolaire trouvée. Veuillez d\'abord exécuter AnneeScolaireSeeder');
            return;
        }

        if ($enseignants->isEmpty()) {
            $this->command->error('❌ Aucun enseignant trouvé. Veuillez d\'abord exécuter EnseignantSeeder');
            return;
        }

        if ($classes->isEmpty()) {
            $this->command->error('❌ Aucune classe trouvée. Veuillez d\'abord exécuter ClasseSeeder');
            return;
        }

        if ($matieres->isEmpty()) {
            $this->command->error('❌ Aucune matière trouvée. Veuillez d\'abord exécuter MatiereSeeder');
            return;
        }

        // Demander le nombre d'évaluations par classe
        $nbEvaluationsParClasse = $this->command->ask('Combien d\'évaluations par classe voulez-vous créer ?', 8);
        
        $this->command->info("🔄 Création des évaluations...");

        $evaluationsCrees = 0;
        $notesCrees = 0;

        foreach ($classes as $classe) {
            // Récupérer les enseignants qui enseignent dans cette classe
            $enseignantsDeLaClasse = $this->getEnseignantsPourClasse($classe);
            
            if ($enseignantsDeLaClasse->isEmpty()) {
                $this->command->warn("  ⚠️ Aucun enseignant trouvé pour la classe {$classe->nom_complet}");
                continue;
            }

            // Créer les évaluations pour cette classe
            for ($i = 0; $i < $nbEvaluationsParClasse; $i++) {
                // Sélectionner un enseignant aléatoire de la classe
                $enseignant = $enseignantsDeLaClasse->random();
                
                // Sélectionner une matière enseignée par cet enseignant dans cette classe
                $matiere = $this->getMatierePourEnseignantClasse($enseignant, $classe);
                
                if (!$matiere) {
                    continue;
                }

                // Déterminer la période
                $periode = $this->periodes[array_rand($this->periodes)];
                
                // Générer la date de l'évaluation (étalée sur l'année)
                $dateEvaluation = $this->genererDateEvaluation($anneeScolaire, $periode);
                
                // Déterminer le nom de l'évaluation
                $nomEvaluation = $this->genererNomEvaluation($matiere->nom);
                
                // Déterminer le coefficient (entre 1 et 3)
                $coefficient = rand(1, 3);
                
                // Déterminer le barème (généralement sur 20)
                $bareme = 20;

                // Créer l'évaluation
                $evaluation = Evaluation::create([
                    'enseignant_id' => $enseignant->id,
                    'classe_id' => $classe->id,
                    'matiere_id' => $matiere->id,
                    'annee_scolaire_id' => $anneeScolaire->id,
                    'type' => $this->typesEvaluation[array_rand($this->typesEvaluation)],
                    'nom' => $nomEvaluation,
                    'description' => $this->genererDescription($nomEvaluation),
                    'date_evaluation' => $dateEvaluation,
                    'coefficient' => $coefficient,
                    'bareme' => $bareme,
                    'periode' => $periode,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $evaluationsCrees++;

                // Créer des notes pour cette évaluation (si elle est passée)
                if ($dateEvaluation < now()) {
                    $notes = $this->creerNotesPourEvaluation($evaluation);
                    $notesCrees += $notes;
                }

                // Afficher la progression
                if (($i + 1) % 5 == 0) {
                    $this->command->line("  ✅ {$i}/{$nbEvaluationsParClasse} évaluations créées pour {$classe->nom_complet}");
                }
            }
        }

        $this->afficherResume($evaluationsCrees, $notesCrees);
    }

    /**
     * Récupérer les enseignants qui enseignent dans une classe
     */
    private function getEnseignantsPourClasse($classe)
    {
        // Via la table EnseignantMatiereClasse
        $enseignantIds = DB::table('enseignant_matiere_classe')
            ->where('classe_id', $classe->id)
            ->distinct('enseignant_id')
            ->pluck('enseignant_id');

        if ($enseignantIds->isNotEmpty()) {
            return Enseignant::whereIn('id', $enseignantIds)->get();
        }

        // Fallback: tous les enseignants
        return Enseignant::all();
    }

    /**
     * Récupérer une matière enseignée par un enseignant dans une classe
     */
    private function getMatierePourEnseignantClasse($enseignant, $classe)
    {
        // Via la table EnseignantMatiereClasse
        $matiereId = DB::table('enseignant_matiere_classe')
            ->where('enseignant_id', $enseignant->id)
            ->where('classe_id', $classe->id)
            ->value('matiere_id');

        if ($matiereId) {
            return Matiere::find($matiereId);
        }

        // Fallback: matière aléatoire
        return Matiere::inRandomOrder()->first();
    }

    /**
     * Générer la date de l'évaluation en fonction de la période
     */
    private function genererDateEvaluation($anneeScolaire, $periode): Carbon
    {
        $dateDebut = Carbon::parse($anneeScolaire->date_debut);
        $dateFin = Carbon::parse($anneeScolaire->date_fin);

        // Répartir les évaluations sur l'année selon la période
        if (str_contains($periode, 'Trimestre 1') || str_contains($periode, 'Semestre 1')) {
            // Premier tiers de l'année
            $intervalle = $dateFin->diffInDays($dateDebut) / 3;
            return $dateDebut->copy()->addDays(rand(10, (int) $intervalle));
        } elseif (str_contains($periode, 'Trimestre 2')) {
            // Deuxième tiers de l'année
            $intervalle = $dateFin->diffInDays($dateDebut) / 3;
            return $dateDebut->copy()->addDays(rand((int) $intervalle + 10, (int) ($intervalle * 2)));
        } elseif (str_contains($periode, 'Trimestre 3') || str_contains($periode, 'Semestre 2')) {
            // Dernier tiers de l'année
            $intervalle = $dateFin->diffInDays($dateDebut) / 3;
            return $dateDebut->copy()->addDays(rand((int) ($intervalle * 2) + 10, (int) ($intervalle * 3) - 10));
        }

        // Aléatoire
        return Carbon::parse($anneeScolaire->date_debut)
            ->addDays(rand(15, $dateFin->diffInDays($dateDebut) - 15));
    }

    /**
     * Générer un nom d'évaluation
     */
    private function genererNomEvaluation($nomMatiere): string
    {
        // Chercher dans les noms prédéfinis pour cette matière
        foreach ($this->nomsParMatiere as $matiere => $noms) {
            if (str_contains($nomMatiere, $matiere) || str_contains($matiere, $nomMatiere)) {
                return $noms[array_rand($noms)];
            }
        }

        // Nom générique
        $prefixes = ['Évaluation', 'Contrôle', 'Devoir', 'Test', 'Interrogation'];
        return $prefixes[array_rand($prefixes)] . ' de ' . $nomMatiere;
    }

    /**
     * Générer une description
     */
    private function genererDescription($nomEvaluation): string
    {
        $descriptions = [
            "{$nomEvaluation} - durée 1h",
            "{$nomEvaluation} - durée 2h",
            "{$nomEvaluation} - sans documents",
            "{$nomEvaluation} - avec documents autorisés",
            "{$nomEvaluation} - à rendre à la fin de l'heure",
            "{$nomEvaluation} - travail individuel",
            "{$nomEvaluation} - travail en groupe",
        ];

        return $descriptions[array_rand($descriptions)];
    }

    /**
     * Créer des notes pour une évaluation
     */
    private function creerNotesPourEvaluation($evaluation): int
    {
        // Récupérer les élèves de la classe
        $eleves = Eleve::whereHas('inscriptions', function($query) use ($evaluation) {
            $query->where('classe_id', $evaluation->classe_id)
                  ->where('statut', true);
        })->get();

        if ($eleves->isEmpty()) {
            return 0;
        }

        $notesCrees = 0;

        foreach ($eleves as $eleve) {
            // Générer une note réaliste (distribution normale)
            $note = $this->genererNoteRealiste($evaluation->bareme);
            
            // Générer une appréciation
            $appreciation = $this->genererAppreciation($note, $evaluation->bareme);

            // Créer la note - SANS date_saisie
            Note::create([
                'eleve_id' => $eleve->id,
                'evaluation_id' => $evaluation->id,
                'note' => $note,
                'observation' => $appreciation,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $notesCrees++;
        }

        return $notesCrees;
    }

    /**
     * Générer une note réaliste (distribution approximative)
     */
    private function genererNoteRealiste($bareme): float
    {
        // Distribution normale approximative
        $rand = rand(1, 100);
        
        if ($rand <= 5) { // 5% de très mauvaises notes
            return round(rand(0, 50) / 10, 1); // 0-5
        } elseif ($rand <= 20) { // 15% de mauvaises notes
            return round(rand(50, 90) / 10, 1); // 5-9
        } elseif ($rand <= 60) { // 40% de notes moyennes
            return round(rand(90, 130) / 10, 1); // 9-13
        } elseif ($rand <= 85) { // 25% de bonnes notes
            return round(rand(130, 160) / 10, 1); // 13-16
        } else { // 15% d'excellentes notes
            return round(rand(160, 200) / 10, 1); // 16-20
        }
    }

    /**
     * Générer une appréciation
     */
    private function genererAppreciation($note, $bareme): string
    {
        $pourcentage = ($note / $bareme) * 100;
        
        if ($pourcentage >= 90) {
            return 'Excellent travail, félicitations !';
        } elseif ($pourcentage >= 80) {
            return 'Très bon travail, continuez ainsi.';
        } elseif ($pourcentage >= 70) {
            return 'Bon travail, quelques points à améliorer.';
        } elseif ($pourcentage >= 60) {
            return 'Travail satisfaisant, peut mieux faire.';
        } elseif ($pourcentage >= 50) {
            return 'Résultats passables, des efforts sont nécessaires.';
        } elseif ($pourcentage >= 40) {
            return 'Insuffisant, doit fournir plus de travail.';
        } else {
            return 'Très insuffisant, une remise à niveau est nécessaire.';
        }
    }

    /**
     * Afficher un résumé des créations
     */
    private function afficherResume(int $evaluationsCrees, int $notesCrees): void
    {
        $totalEvaluations = Evaluation::count();
        $statsParType = Evaluation::selectRaw('type, count(*) as total')
            ->groupBy('type')
            ->orderBy('total', 'desc')
            ->get();

        $statsParMatiere = Evaluation::selectRaw('matiere_id, count(*) as total')
            ->groupBy('matiere_id')
            ->with('matiere')
            ->get();

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES ÉVALUATIONS');
        $this->command->info("Total évaluations : {$totalEvaluations}");
        $this->command->info("Évaluations créées maintenant : {$evaluationsCrees}");
        $this->command->info("Notes générées : {$notesCrees}");
        $this->command->info('------------------------------------');
        
        $this->command->info('📋 Répartition par type :');
        foreach ($statsParType as $stat) {
            $pourcentage = round(($stat->total / $totalEvaluations) * 100, 1);
            $this->command->line("  • {$stat->type} : {$stat->total} ({$pourcentage}%)");
        }

        $this->command->info('------------------------------------');
        
        $this->command->info('📚 Top 5 des matières :');
        $topMatieres = $statsParMatiere->sortByDesc('total')->take(5);
        foreach ($topMatieres as $stat) {
            if ($stat->matiere) {
                $pourcentage = round(($stat->total / $totalEvaluations) * 100, 1);
                $this->command->line("  • {$stat->matiere->nom} : {$stat->total} ({$pourcentage}%)");
            }
        }
        
        $this->command->info('====================================');
        $this->command->info('✅ Seeder Evaluation exécuté avec succès !');
    }
}