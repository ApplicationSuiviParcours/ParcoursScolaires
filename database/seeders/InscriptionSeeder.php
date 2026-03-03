<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inscription;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use Carbon\Carbon;

class InscriptionSeeder extends Seeder
{
    /**
     * Types d'observations pour les inscriptions
     */
    private array $observations = [
        'Frais d\'inscription payés',
        'Dossier complet',
        'Demi-pensionnaire',
        'Externe',
        'Interné',
        'Boursier',
        'Redoublant',
        'Nouveau dans l\'établissement',
        'Vient du public',
        'Vient du privé',
        'Demande de bourse en cours',
        'Pièces manquantes (certificat médical)',
        'Photo manquante',
        'Autorisation de sortie signée',
        'Règlement intérieur signé',
        null, // Pas d'observation
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les données nécessaires
        $anneeScolaireActive = AnneeScolaire::active()->first() ?? AnneeScolaire::first();
        $eleves = Eleve::all();
        $classes = Classe::all();

        // Vérifications
        if (!$anneeScolaireActive) {
            $this->command->error('❌ Aucune année scolaire trouvée. Veuillez d\'abord exécuter AnneeScolaireSeeder');
            return;
        }

        if ($eleves->isEmpty()) {
            $this->command->error('❌ Aucun élève trouvé. Veuillez d\'abord exécuter EleveSeeder');
            return;
        }

        if ($classes->isEmpty()) {
            $this->command->error('❌ Aucune classe trouvée. Veuillez d\'abord exécuter ClasseSeeder');
            return;
        }

        // Supprimer les anciennes inscriptions (optionnel)
        // Inscription::truncate();

        $this->command->info('🔄 Création des inscriptions pour l\'année scolaire ' . $anneeScolaireActive->nom . '...');

        $inscriptionsCrees = 0;
        $elevesDejaInscrits = [];
        $compteurClasses = [];

        // Initialiser le compteur pour chaque classe
        foreach ($classes as $classe) {
            $compteurClasses[$classe->id] = 0;
        }

        foreach ($eleves as $eleve) {
            // Vérifier si l'élève a déjà une inscription active
            $inscriptionExistante = Inscription::where('eleve_id', $eleve->id)
                ->where('annee_scolaire_id', $anneeScolaireActive->id)
                ->where('statut', true)
                ->exists();

            if ($inscriptionExistante) {
                $this->command->line("  ⚠️ L'élève {$eleve->nom_complet} a déjà une inscription active");
                $elevesDejaInscrits[] = $eleve->id;
                continue;
            }

            // Déterminer la classe de l'élève (soit depuis eleve->classe_actuelle, soit aléatoire)
            $classe = $this->determinerClassePourEleve($eleve, $classes, $compteurClasses);
            
            if (!$classe) {
                $this->command->warn("  ⚠️ Aucune classe disponible pour l'élève {$eleve->nom_complet}");
                continue;
            }

            // Vérifier la capacité de la classe
            if ($compteurClasses[$classe->id] >= $classe->capacite) {
                $this->command->warn("  ⚠️ La classe {$classe->nom_complet} a atteint sa capacité maximale");
                continue;
            }

            // Générer la date d'inscription (entre début d'année et aujourd'hui)
            $dateInscription = $this->genererDateInscription($anneeScolaireActive);
            
            // Déterminer le statut (90% actif)
            $statut = rand(0, 100) <= 90; // 90% de chances d'être actif
            
            // Sélectionner une observation aléatoire
            $observation = $this->observations[array_rand($this->observations)];

            // Créer l'inscription
            Inscription::create([
                'eleve_id' => $eleve->id,
                'classe_id' => $classe->id,
                'annee_scolaire_id' => $anneeScolaireActive->id,
                'date_inscription' => $dateInscription,
                'statut' => $statut,
                'observation' => $observation,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $inscriptionsCrees++;
            $compteurClasses[$classe->id]++;

            // Afficher la progression
            if ($inscriptionsCrees % 20 == 0) {
                $this->command->line("  ✅ {$inscriptionsCrees} inscriptions créées...");
            }
        }

        // Créer des inscriptions historiques pour les années précédentes
        $inscriptionsHistoriques = $this->creerInscriptionsHistoriques($eleves, $classes, $anneeScolaireActive);
        $inscriptionsCrees += $inscriptionsHistoriques;

        // Afficher le résumé
        $this->afficherResume($inscriptionsCrees, $compteurClasses, $classes, $elevesDejaInscrits);
    }

    /**
     * Déterminer la classe pour un élève
     */
    private function determinerClassePourEleve($eleve, $classes, &$compteurClasses)
    {
        // Essayer d'abord d'utiliser la classe actuelle de l'élève (si elle existe)
        if (method_exists($eleve, 'classe_actuelle') && $eleve->classe_actuelle) {
            $classe = $eleve->classe_actuelle;
            // Vérifier que la classe existe dans notre liste
            if ($classes->contains('id', $classe->id)) {
                return $classe;
            }
        }

        // Sinon, chercher une classe avec de la place
        $classesDisponibles = $classes->filter(function($classe) use ($compteurClasses) {
            return $compteurClasses[$classe->id] < $classe->capacite;
        });

        if ($classesDisponibles->isEmpty()) {
            return null;
        }

        // Retourner une classe aléatoire parmi celles disponibles
        return $classesDisponibles->random();
    }

    /**
     * Générer une date d'inscription réaliste
     */
    private function genererDateInscription($anneeScolaire): Carbon
    {
        $dateDebut = Carbon::parse($anneeScolaire->date_debut);
        $dateFin = Carbon::parse($anneeScolaire->date_fin);
        $aujourdhui = Carbon::now();

        // La date d'inscription ne peut pas dépasser aujourd'hui
        $dateMax = $aujourdhui->min($dateFin);

        // 80% des inscriptions ont lieu dans les 2 premiers mois de l'année
        if (rand(0, 100) <= 80) {
            $dateMax = $dateDebut->copy()->addMonths(2)->min($dateMax);
        }

        return Carbon::createFromTimestamp(
            rand($dateDebut->timestamp, $dateMax->timestamp)
        );
    }

    /**
     * Créer des inscriptions pour les années précédentes
     */
    private function creerInscriptionsHistoriques($eleves, $classes, $anneeCourante): int
    {
        $inscriptionsCrees = 0;
        
        // Récupérer les années scolaires précédentes
        $anneesPrecedentes = AnneeScolaire::where('date_fin', '<', $anneeCourante->date_debut)
            ->orderBy('date_debut', 'desc')
            ->take(2)
            ->get();

        if ($anneesPrecedentes->isEmpty()) {
            return 0;
        }

        $this->command->info('🔄 Création des inscriptions historiques...');

        // Sélectionner 30% des élèves pour avoir un historique
        $elevesAvecHistorique = $eleves->random($eleves->count() * 0.3);

        foreach ($elevesAvecHistorique as $eleve) {
            // Pour chaque année précédente
            foreach ($anneesPrecedentes as $annee) {
                // 70% de chances d'avoir été inscrit cette année-là
                if (rand(0, 100) <= 70) {
                    // Sélectionner une classe aléatoire
                    $classe = $classes->random();

                    // Vérifier si l'inscription existe déjà
                    $existe = Inscription::where('eleve_id', $eleve->id)
                        ->where('annee_scolaire_id', $annee->id)
                        ->exists();

                    if (!$existe) {
                        // Date d'inscription au début de l'année
                        $dateInscription = Carbon::parse($annee->date_debut)
                            ->addDays(rand(1, 30));

                        Inscription::create([
                            'eleve_id' => $eleve->id,
                            'classe_id' => $classe->id,
                            'annee_scolaire_id' => $annee->id,
                            'date_inscription' => $dateInscription,
                            'statut' => false, // Inscriptions historiques inactives
                            'observation' => 'Inscription année précédente',
                            'created_at' => $dateInscription,
                            'updated_at' => $dateInscription,
                        ]);

                        $inscriptionsCrees++;
                    }
                }
            }
        }

        return $inscriptionsCrees;
    }

    /**
     * Afficher un résumé des inscriptions créées
     */
    private function afficherResume(int $inscriptionsCrees, array $compteurClasses, $classes, array $elevesDejaInscrits): void
    {
        $totalInscriptions = Inscription::count();
        $inscriptionsActives = Inscription::where('statut', true)->count();
        $inscriptionsParClasse = Inscription::selectRaw('classe_id, count(*) as total')
            ->where('statut', true)
            ->groupBy('classe_id')
            ->with('classe')
            ->get();

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES INSCRIPTIONS');
        $this->command->info("Total inscriptions dans la base : {$totalInscriptions}");
        $this->command->info("Inscriptions créées maintenant : {$inscriptionsCrees}");
        $this->command->info("Inscriptions actives : {$inscriptionsActives}");
        $this->command->info("Élèves déjà inscrits : " . count($elevesDejaInscrits));
        $this->command->info('------------------------------------');
        
        $this->command->info('📚 Répartition par classe :');
        foreach ($inscriptionsParClasse as $stat) {
            if ($stat->classe) {
                $capacite = $stat->classe->capacite;
                $pourcentage = round(($stat->total / $capacite) * 100, 1);
                $statut = $pourcentage >= 100 ? '🔴' : ($pourcentage >= 80 ? '🟡' : '🟢');
                $this->command->line("  {$statut} {$stat->classe->nom_complet} : {$stat->total}/{$capacite} élèves ({$pourcentage}%)");
            }
        }

        // Calcul des statistiques globales
        $totalCapacite = $classes->sum('capacite');
        $totalPlacesOccupees = $inscriptionsParClasse->sum('total');
        $tauxGlobal = $totalCapacite > 0 ? round(($totalPlacesOccupees / $totalCapacite) * 100, 1) : 0;

        $this->command->info('------------------------------------');
        $this->command->info("📈 Taux d'occupation global : {$tauxGlobal}%");
        $this->command->info("🏫 Capacité totale : {$totalCapacite} places");
        $this->command->info("👥 Places occupées : {$totalPlacesOccupees}");
        $this->command->info("🆓 Places disponibles : " . ($totalCapacite - $totalPlacesOccupees));
        $this->command->info('====================================');
        $this->command->info('✅ Seeder Inscription exécuté avec succès !');
    }
}