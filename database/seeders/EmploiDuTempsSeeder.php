<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmploiDuTemps;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Enseignant;
use App\Models\AnneeScolaire;
use App\Models\ClasseMatiere;
use App\Models\EnseignantMatiereClasse;
use Carbon\Carbon;

class EmploiDuTempsSeeder extends Seeder
{
    /**
     * Jours de la semaine
     */
    private array $jours = [
        'Lundi',
        'Mardi',
        'Mercredi',
        'Jeudi',
        'Vendredi',
        'Samedi',
    ];

    /**
     * Créneaux horaires standards
     */
    private array $creneaux = [
        ['debut' => '08:00', 'fin' => '09:00', 'type' => 'Cours'],
        ['debut' => '09:00', 'fin' => '10:00', 'type' => 'Cours'],
        ['debut' => '10:00', 'fin' => '11:00', 'type' => 'Cours'],
        ['debut' => '11:00', 'fin' => '12:00', 'type' => 'Cours'],
        ['debut' => '12:00', 'fin' => '13:00', 'type' => 'Pause'], // Pause déjeuner
        ['debut' => '13:00', 'fin' => '14:00', 'type' => 'Cours'],
        ['debut' => '14:00', 'fin' => '15:00', 'type' => 'Cours'],
        ['debut' => '15:00', 'fin' => '16:00', 'type' => 'Cours'],
        ['debut' => '16:00', 'fin' => '17:00', 'type' => 'Cours'],
        ['debut' => '17:00', 'fin' => '18:00', 'type' => 'Cours'],
    ];

    /**
     * Salles disponibles
     */
    private array $salles = [
        'A101', 'A102', 'A103', 'A201', 'A202', 'A203',
        'B101', 'B102', 'B103', 'B201', 'B202', 'B203',
        'Labo 1', 'Labo 2', 'Labo 3',
        'Salle informatique 1', 'Salle informatique 2',
        'Amphithéâtre A', 'Amphithéâtre B',
        'CDI', 'Salle de sport',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les données nécessaires
        $anneeScolaire = AnneeScolaire::active()->first() ?? AnneeScolaire::first();
        $classes = Classe::all();
        $enseignants = Enseignant::all();
        $matieres = Matiere::all();

        if (!$anneeScolaire) {
            $this->command->error('❌ Aucune année scolaire trouvée. Veuillez d\'abord exécuter AnneeScolaireSeeder');
            return;
        }

        if ($classes->isEmpty()) {
            $this->command->error('❌ Aucune classe trouvée. Veuillez d\'abord exécuter ClasseSeeder');
            return;
        }

        if ($enseignants->isEmpty()) {
            $this->command->warn('⚠️ Aucun enseignant trouvé. Les emplois du temps seront créés sans enseignants.');
        }

        if ($matieres->isEmpty()) {
            $this->command->error('❌ Aucune matière trouvée. Veuillez d\'abord exécuter MatiereSeeder');
            return;
        }

        // Supprimer les anciens emplois du temps (optionnel)
        // EmploiDuTemps::truncate();

        $this->command->info('🔄 Création des emplois du temps...');

        $totalCours = 0;
        $conflitsEvites = 0;

        foreach ($classes as $classe) {
            $this->command->line("📚 Création de l'emploi du temps pour {$classe->nom_complet}...");
            
            // Récupérer les matières de la classe (via ClasseMatiere)
            $matieresDeLaClasse = $this->getMatieresPourClasse($classe);
            
            if ($matieresDeLaClasse->isEmpty()) {
                $this->command->warn("  ⚠️ Aucune matière trouvée pour cette classe");
                continue;
            }

            // Créer l'emploi du temps pour chaque jour
            foreach ($this->jours as $jour) {
                $coursDuJour = $this->creerEmploiDuTempsPourJour(
                    $classe,
                    $matieresDeLaClasse,
                    $enseignants,
                    $anneeScolaire->id,
                    $jour
                );

                $totalCours += count($coursDuJour);
            }

            // Vérifier et résoudre les conflits potentiels
            $conflits = $this->verifierConflits($classe->id, $anneeScolaire->id);
            $conflitsEvites += $conflits;
        }

        $this->afficherResume($totalCours, $conflitsEvites);
    }

    /**
     * Récupérer les matières pour une classe
     */
    private function getMatieresPourClasse($classe)
    {
        // Via la table ClasseMatiere
        $classeMatieres = ClasseMatiere::where('classe_id', $classe->id)
            ->with('matiere')
            ->get();

        if ($classeMatieres->isNotEmpty()) {
            return $classeMatieres->pluck('matiere')->filter();
        }

        // Fallback: toutes les matières
        return Matiere::inRandomOrder()->take(8)->get();
    }

    /**
     * Créer l'emploi du temps pour un jour spécifique
     */
    private function creerEmploiDuTempsPourJour($classe, $matieres, $enseignants, $anneeScolaireId, $jour): array
    {
        $coursCrees = [];
        $matieresUtilisees = [];
        $enseignantsOccupes = [];

        foreach ($this->creneaux as $index => $creneau) {
            // Ne pas créer de cours pendant la pause
            if ($creneau['type'] === 'Pause') {
                continue;
            }

            // Limiter le nombre de cours par jour (max 6)
            if (count($coursCrees) >= 6) {
                break;
            }

            // Sélectionner une matière aléatoire non encore utilisée aujourd'hui (ou avec répétition possible)
            $matiereDisponible = $matieres->filter(function($matiere) use ($matieresUtilisees, $index) {
                // Permettre 2 cours de la même matière par jour max
                $countUtilisations = array_count_values($matieresUtilisees)[$matiere->id] ?? 0;
                return $countUtilisations < 2;
            })->random();

            if (!$matiereDisponible) {
                continue;
            }

            // Trouver un enseignant pour cette matière
            $enseignant = $this->trouverEnseignantPourMatiere($matiereDisponible, $classe, $enseignants, $enseignantsOccupes);

            // Vérifier que l'enseignant n'est pas déjà occupé à ce créneau
            if ($enseignant && $this->enseignantEstOccupe($enseignant->id, $jour, $creneau['debut'], $creneau['fin'], $anneeScolaireId)) {
                continue;
            }

            // Sélectionner une salle aléatoire
            $salle = $this->salles[array_rand($this->salles)];

            // Créer le cours
            $cours = EmploiDuTemps::create([
                'classe_id' => $classe->id,
                'matiere_id' => $matiereDisponible->id,
                'enseignant_id' => $enseignant?->id,
                'annee_scolaire_id' => $anneeScolaireId,
                'jour' => $jour,
                'heure_debut' => $creneau['debut'],
                'heure_fin' => $creneau['fin'],
                'salle' => $salle,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $coursCrees[] = $cours;
            $matieresUtilisees[] = $matiereDisponible->id;
            
            if ($enseignant) {
                $enseignantsOccupes[] = [
                    'enseignant_id' => $enseignant->id,
                    'creneau' => $creneau['debut'] . '-' . $creneau['fin']
                ];
            }
        }

        return $coursCrees;
    }

    /**
     * Trouver un enseignant pour une matière
     */
    private function trouverEnseignantPourMatiere($matiere, $classe, $enseignants, $enseignantsOccupes)
    {
        if ($enseignants->isEmpty()) {
            return null;
        }

        // Chercher via EnseignantMatiereClasse
        $affectation = EnseignantMatiereClasse::where('matiere_id', $matiere->id)
            ->where('classe_id', $classe->id)
            ->with('enseignant')
            ->first();

        if ($affectation && $affectation->enseignant) {
            return $affectation->enseignant;
        }

        // Fallback: enseignant aléatoire qui n'est pas déjà occupé
        $enseignantDisponible = $enseignants->filter(function($enseignant) use ($enseignantsOccupes) {
            $occupe = false;
            foreach ($enseignantsOccupes as $occupeInfo) {
                if ($occupeInfo['enseignant_id'] === $enseignant->id) {
                    $occupe = true;
                    break;
                }
            }
            return !$occupe;
        })->first();

        return $enseignantDisponible ?? $enseignants->random();
    }

    /**
     * Vérifier si un enseignant est déjà occupé à un créneau
     */
    private function enseignantEstOccupe($enseignantId, $jour, $heureDebut, $heureFin, $anneeScolaireId): bool
    {
        return EmploiDuTemps::where('enseignant_id', $enseignantId)
            ->where('annee_scolaire_id', $anneeScolaireId)
            ->where('jour', $jour)
            ->where(function($query) use ($heureDebut, $heureFin) {
                $query->where(function($q) use ($heureDebut, $heureFin) {
                    $q->where('heure_debut', '<', $heureFin)
                      ->where('heure_fin', '>', $heureDebut);
                });
            })
            ->exists();
    }

    /**
     * Vérifier les conflits potentiels (même salle au même moment)
     */
    private function verifierConflits($classeId, $anneeScolaireId): int
    {
        $conflits = 0;
        
        // Récupérer tous les cours de la classe
        $cours = EmploiDuTemps::where('classe_id', $classeId)
            ->where('annee_scolaire_id', $anneeScolaireId)
            ->get();

        // Vérifier les conflits de salle
        foreach ($cours as $cours1) {
            foreach ($cours as $cours2) {
                if ($cours1->id >= $cours2->id) {
                    continue;
                }

                // Même jour, même salle, horaires qui se chevauchent
                if ($cours1->jour === $cours2->jour && 
                    $cours1->salle === $cours2->salle &&
                    $cours1->heure_debut < $cours2->heure_fin &&
                    $cours1->heure_fin > $cours2->heure_debut) {
                    
                    $conflits++;
                    
                    // Résoudre le conflit en changeant la salle du deuxième cours
                    $nouvellesSalles = array_diff($this->salles, [$cours2->salle]);
                    $cours2->update(['salle' => $nouvellesSalles[array_rand($nouvellesSalles)]]);
                }
            }
        }

        return $conflits;
    }

    /**
     * Afficher un résumé des emplois du temps créés
     */
    private function afficherResume(int $totalCours, int $conflitsEvites): void
    {
        $stats = EmploiDuTemps::selectRaw('classe_id, count(*) as total')
            ->groupBy('classe_id')
            ->with('classe')
            ->get();

        $totalClasses = $stats->count();
        $totalCoursReel = EmploiDuTemps::count();

        $this->command->info('====================================');
        $this->command->info('📊 RÉSUMÉ DES EMPLOIS DU TEMPS');
        $this->command->info("Total cours créés : {$totalCoursReel}");
        $this->command->info("Classes concernées : {$totalClasses}");
        $this->command->info("Conflits résolus : {$conflitsEvites}");
        $this->command->info('------------------------------------');
        
        foreach ($stats as $stat) {
            if ($stat->classe) {
                $coursParJour = EmploiDuTemps::where('classe_id', $stat->classe_id)
                    ->selectRaw('jour, count(*) as total')
                    ->groupBy('jour')
                    ->get();

                $this->command->line("{$stat->classe->nom_complet} : {$stat->total} cours");
                
                foreach ($coursParJour as $cj) {
                    $this->command->line("  • {$cj->jour} : {$cj->total} cours");
                }
            }
        }
        
        $this->command->info('====================================');
        $this->command->info('✅ Seeder EmploiDuTemps exécuté avec succès !');
    }
}