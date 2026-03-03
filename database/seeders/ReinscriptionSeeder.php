<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reinscription;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Inscription;
use Carbon\Carbon;

class ReinscriptionSeeder extends Seeder
{
    /**
     * Types d'observations pour les réinscriptions
     */
    private array $observations = [
        'Famille réinscrite sans changement',
        'Changement de classe',
        'Dossier complet',
        'Frais de réinscription payés',
        'Bourse renouvelée',
        'Nouvelle option choisie',
        'Redoublement',
        'Passage en classe supérieure',
        'Changement d\'établissement scolaire',
        'Dossier médical à fournir',
        'Photo d\'identité à fournir',
        'Autorisation de sortie à signer',
        null,
        null,
        null,
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les données nécessaires
        $eleves = Eleve::all();
        $classes = Classe::all();
        $anneeCourante = AnneeScolaire::active()->first() ?? AnneeScolaire::first();
        $anneesPrecedentes = AnneeScolaire::where('id', '!=', $anneeCourante->id)
            ->orderBy('date_debut', 'desc')
            ->get();

        // Vérifications
        if ($eleves->isEmpty()) {
            $this->command->error('❌ Aucun élève trouvé. Veuillez d\'abord exécuter EleveSeeder');
            return;
        }

        if ($classes->isEmpty()) {
            $this->command->error('❌ Aucune classe trouvée. Veuillez d\'abord exécuter ClasseSeeder');
            return;
        }

        if (!$anneeCourante) {
            $this->command->error('❌ Aucune année scolaire trouvée. Veuillez d\'abord exécuter AnneeScolaireSeeder');
            return;
        }

        $this->command->info('🔄 Création des réinscriptions...');

        $reinscriptionsCrees = 0;
        $reinscriptionsParStatut = [
            'en_attente' => 0,
            'confirmee' => 0,
            'annulee' => 0,
        ];

        // Filtrer les élèves qui ont une inscription pour l'année précédente
        $elevesAvecInscriptionPrecedente = $this->getElevesAvecInscriptionPrecedente($eleves, $anneesPrecedentes);

        if ($elevesAvecInscriptionPrecedente->isEmpty()) {
            $this->command->warn('⚠️ Aucun élève avec inscription précédente trouvé.');
        } else {
            $this->command->info("📋 " . $elevesAvecInscriptionPrecedente->count() . " élèves éligibles à la réinscription");

            foreach ($elevesAvecInscriptionPrecedente as $eleve) {
                // Récupérer la dernière inscription de l'élève
                $derniereInscription = $eleve->inscriptions()
                    ->where('annee_scolaire_id', '!=', $anneeCourante->id)
                    ->latest()
                    ->first();

                if (!$derniereInscription) {
                    continue;
                }

                // Déterminer la nouvelle classe
                $nouvelleClasse = $this->determinerNouvelleClasse(
                    $derniereInscription->classe,
                    $classes
                );

                // Déterminer le statut de la réinscription
                $statut = $this->determinerStatutReinscription();

                // Déterminer la date de réinscription
                $dateReinscription = $this->genererDateReinscription($anneeCourante);

                // Générer une observation
                $observation = $this->observations[array_rand($this->observations)];

                // Créer la réinscription
                Reinscription::create([
                    'eleve_id' => $eleve->id,
                    'classe_id' => $nouvelleClasse->id,
                    'annee_scolaire_id' => $anneeCourante->id,
                    'date_reinscription' => $dateReinscription,
                    'statut' => $statut,
                    'observation' => $observation,
                    'created_at' => $dateReinscription,
                    'updated_at' => $dateReinscription,
                ]);

                $reinscriptionsCrees++;
                $reinscriptionsParStatut[$statut]++;

                // Mettre à jour l'inscription si la réinscription est confirmée
                if ($statut === 'confirmee') {
                    $this->mettreAJourInscription($eleve, $nouvelleClasse, $anneeCourante, $dateReinscription);
                }
            }
        }

        // Créer des réinscriptions pour l'année en cours (anticipations)
        $reinscriptionsAnticipees = $this->creerReinscriptionsAnticipees($eleves, $classes, $anneeCourante);
        $reinscriptionsCrees += $reinscriptionsAnticipees['total'];
        $reinscriptionsParStatut['en_attente'] += $reinscriptionsAnticipees['en_attente'];

        // Afficher le résumé
        $this->afficherResume(
            $reinscriptionsCrees,
            $reinscriptionsParStatut,
            $elevesAvecInscriptionPrecedente->count()
        );
    }

    /**
     * Récupérer les élèves qui ont une inscription pour l'année précédente
     */
    private function getElevesAvecInscriptionPrecedente($eleves, $anneesPrecedentes)
    {
        if ($anneesPrecedentes->isEmpty()) {
            return collect([]);
        }

        $anneeIds = $anneesPrecedentes->pluck('id')->toArray();

        return $eleves->filter(function($eleve) use ($anneeIds) {
            return $eleve->inscriptions()
                ->whereIn('annee_scolaire_id', $anneeIds)
                ->exists();
        });
    }

    /**
     * Déterminer la nouvelle classe de l'élève
     */
    private function determinerNouvelleClasse($ancienneClasse, $toutesLesClasses)
    {
        // Logique de progression scolaire
        $niveaux = [
            'CP1' => 'CP2',
            'CP2' => 'CE1',
            'CE1' => 'CE2',
            'CE2' => 'CM1',
            'CM1' => 'CM2',
            'CM2' => '6ème',
            '6ème' => '5ème',
            '5ème' => '4ème',
            '4ème' => '3ème',
            '3ème' => 'Seconde',
            'Seconde' => 'Première',
            'Première' => 'Terminale',
            'Terminale' => 'Baccalauréat',
        ];

        $nouveauNiveau = $niveaux[$ancienneClasse->niveau] ?? null;

        if ($nouveauNiveau && $nouveauNiveau !== 'Baccalauréat') {
            // Chercher une classe avec le nouveau niveau
            $nouvelleClasse = $toutesLesClasses
                ->where('niveau', $nouveauNiveau)
                ->where('serie', $ancienneClasse->serie)
                ->first();

            if ($nouvelleClasse) {
                return $nouvelleClasse;
            }
        }

        // 10% de chance de redoublement
        if (rand(0, 100) <= 10) {
            return $ancienneClasse; // Redoublement
        }

        // Par défaut, prendre une classe aléatoire
        return $toutesLesClasses->random();
    }

    /**
     * Déterminer le statut de la réinscription
     */
    private function determinerStatutReinscription(): string
    {
        $rand = rand(1, 100);

        if ($rand <= 70) { // 70% confirmées
            return 'confirmee';
        } elseif ($rand <= 90) { // 20% en attente
            return 'en_attente';
        } else { // 10% annulées
            return 'annulee';
        }
    }

    /**
     * Générer une date de réinscription
     */
    private function genererDateReinscription($anneeScolaire): Carbon
    {
        $dateDebut = Carbon::parse($anneeScolaire->date_debut);
        $maintenant = Carbon::now();

        // Les réinscriptions ont lieu entre 2 mois avant la rentrée et 1 mois après
        $dateMin = $dateDebut->copy()->subMonths(2);
        $dateMax = $dateDebut->copy()->addMonth()->min($maintenant);

        return Carbon::createFromTimestamp(
            rand($dateMin->timestamp, $dateMax->timestamp)
        );
    }

    /**
     * Mettre à jour l'inscription de l'élève
     */
    private function mettreAJourInscription($eleve, $nouvelleClasse, $anneeScolaire, $dateReinscription): void
    {
        // Désactiver l'ancienne inscription
        $eleve->inscriptions()->update(['statut' => false]);

        // Créer une nouvelle inscription ou mettre à jour l'existante
        $inscription = Inscription::updateOrCreate(
            [
                'eleve_id' => $eleve->id,
                'annee_scolaire_id' => $anneeScolaire->id,
            ],
            [
                'classe_id' => $nouvelleClasse->id,
                'date_inscription' => $dateReinscription,
                'statut' => true,
                'observation' => 'Réinscription automatique',
            ]
        );
    }

    /**
     * Créer des réinscriptions anticipées
     */
    private function creerReinscriptionsAnticipees($eleves, $classes, $anneeCourante): array
    {
        $total = 0;
        $enAttente = 0;

        // Sélectionner 20% des élèves pour des réinscriptions anticipées
        $elevesSelectionnes = $eleves->random($eleves->count() * 0.2);

        foreach ($elevesSelectionnes as $eleve) {
            // Vérifier si une réinscription existe déjà
            $existe = Reinscription::where('eleve_id', $eleve->id)
                ->where('annee_scolaire_id', $anneeCourante->id)
                ->exists();

            if (!$existe) {
                // Choisir une classe aléatoire
                $classe = $classes->random();

                // Date anticipée (avant la rentrée)
                $dateReinscription = Carbon::parse($anneeCourante->date_debut)
                    ->subMonths(rand(1, 3))
                    ->subDays(rand(1, 15));

                Reinscription::create([
                    'eleve_id' => $eleve->id,
                    'classe_id' => $classe->id,
                    'annee_scolaire_id' => $anneeCourante->id,
                    'date_reinscription' => $dateReinscription,
                    'statut' => 'en_attente',
                    'observation' => 'Pré-inscription anticipée',
                    'created_at' => $dateReinscription,
                    'updated_at' => $dateReinscription,
                ]);

                $total++;
                $enAttente++;
            }
        }

        return ['total' => $total, 'en_attente' => $enAttente];
    }

    /**
     * Afficher un résumé des réinscriptions créées
     */
    private function afficherResume(int $total, array $stats, int $elevesEligibles): void
    {
        $totalReinscriptions = Reinscription::count();

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES RÉINSCRIPTIONS');
        $this->command->info("Total réinscriptions dans la base : {$totalReinscriptions}");
        $this->command->info("Réinscriptions créées maintenant : {$total}");
        $this->command->info("Élèves éligibles : {$elevesEligibles}");
        $this->command->info('------------------------------------');
        
        $this->command->info('📈 Répartition par statut :');
        $this->command->line("  • ✅ Confirmées : {$stats['confirmee']}");
        $this->command->line("  • ⏳ En attente : {$stats['en_attente']}");
        $this->command->line("  • ❌ Annulées : {$stats['annulee']}");

        // Taux de réinscription
        $tauxReinscription = $elevesEligibles > 0 
            ? round(($stats['confirmee'] / $elevesEligibles) * 100, 1) 
            : 0;

        $this->command->info('------------------------------------');
        $this->command->info("📊 Taux de réinscription : {$tauxReinscription}%");

        // Répartition par classe
        $reinscriptionsParClasse = Reinscription::selectRaw('classe_id, count(*) as total')
            ->groupBy('classe_id')
            ->with('classe')
            ->get();

        if ($reinscriptionsParClasse->isNotEmpty()) {
            $this->command->info('------------------------------------');
            $this->command->info('🏫 Répartition par classe :');
            
            foreach ($reinscriptionsParClasse->take(5) as $stat) {
                if ($stat->classe) {
                    $pourcentage = round(($stat->total / $totalReinscriptions) * 100, 1);
                    $this->command->line("  • {$stat->classe->nom_complet} : {$stat->total} ({$pourcentage}%)");
                }
            }
        }

        $this->command->info('====================================');
        $this->command->info('✅ Seeder Reinscription exécuté avec succès !');
    }
}