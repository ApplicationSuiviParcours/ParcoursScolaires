<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmploiDuTemps;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Enseignant;
use App\Models\AnneeScolaire;

class EmploiDuTempsSeeder extends Seeder
{
    /**
     * Crée des emplois du temps sans conflit :
     * - Chaque enseignant n'est assigné qu'à un seul créneau par jour
     * - Chaque classe n'a qu'un seul cours par créneau
     */
    public function run(): void
    {
        $classes    = Classe::all();
        $matieres   = Matiere::all();
        $enseignants = Enseignant::all();
        $annee      = AnneeScolaire::where('active', true)->first();

        if ($classes->isEmpty() || $matieres->isEmpty() || $enseignants->isEmpty() || !$annee) {
            $this->command->error('❌ Need classes, matieres, enseignants, annee');
            return;
        }

        $this->command->info('🔄 Creating emploi du temps entries (sans conflits)...');

        // Créneaux horaires fixes
        $horaires = [
            1 => ['08:00', '09:30'],
            2 => ['09:45', '11:15'],
            3 => ['11:30', '13:00'],
            4 => ['14:00', '15:30'],
            5 => ['15:45', '17:15'],
        ];

        // Jours : 1=Lundi à 5=Vendredi
        $jours = [1, 2, 3, 4, 5];

        // Suivi des conflits en mémoire
        // $occupied[jour][slot] = [enseignant_ids, classe_ids, salles]
        $teacherBusy = []; // $teacherBusy[$jour][$slot][] = enseignant_id
        $classBusy   = []; // $classBusy[$jour][$slot][] = classe_id

        $created = 0;
        $enseignantsList = $enseignants->values();
        $enseignantCount = $enseignantsList->count();
        $enseignantIndex = 0;

        foreach ($classes as $classe) {
            // Attribuer 2 cours par classe, sur des jours/créneaux différents
            $assignedSlots = [];

            foreach ($jours as $jour) {
                if (count($assignedSlots) >= 2) break;

                foreach ($horaires as $slotNum => $horaire) {
                    // Vérifier conflit de classe
                    if (in_array("{$jour}_{$slotNum}", $assignedSlots)) continue;

                    if (isset($classBusy[$jour][$slotNum]) &&
                        in_array($classe->id, $classBusy[$jour][$slotNum])) {
                        continue;
                    }

                    // Trouver un enseignant disponible pour ce créneau
                    $enseignantTrouve = null;
                    for ($i = 0; $i < $enseignantCount; $i++) {
                        $candidat = $enseignantsList[($enseignantIndex + $i) % $enseignantCount];
                        $busyKey = "{$jour}_{$slotNum}";
                        if (!isset($teacherBusy[$busyKey]) ||
                            !in_array($candidat->id, $teacherBusy[$busyKey])) {
                            $enseignantTrouve = $candidat;
                            $enseignantIndex = ($enseignantIndex + $i + 1) % $enseignantCount;
                            break;
                        }
                    }

                    if (!$enseignantTrouve) continue;

                    // Créer l'entrée
                    EmploiDuTemps::create([
                        'classe_id'        => $classe->id,
                        'matiere_id'       => $matieres->random()->id,
                        'enseignant_id'    => $enseignantTrouve->id,
                        'jour'             => $jour,
                        'heure_debut'      => $horaire[0],
                        'heure_fin'        => $horaire[1],
                        'salle'            => 'Salle ' . chr(64 + $slotNum),
                        'annee_scolaire_id' => $annee->id,
                    ]);

                    // Marquer comme occupé
                    $busyKey = "{$jour}_{$slotNum}";
                    $teacherBusy[$busyKey][] = $enseignantTrouve->id;
                    $classBusy[$jour][$slotNum][] = $classe->id;
                    $assignedSlots[] = "{$jour}_{$slotNum}";
                    $created++;
                    break;
                }
            }
        }

        $this->command->info("✅ {$created} emploi du temps entries created (sans conflit)!");
    }
}