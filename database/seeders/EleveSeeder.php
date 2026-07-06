<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Inscription;
use App\Models\User;
use Carbon\Carbon;

class EleveSeeder extends Seeder
{
    /**
     * Exactly 5 élèves with Congolese names
     */
    private array $eleves = [
        ['prenom' => 'Mouana', 'nom' => 'Pemba', 'genre' => 'm', 'email' => 'mouana@eleve.cg'],
        ['prenom' => 'Koubemba', 'nom' => 'Ngoma', 'genre' => 'f', 'email' => 'koubemba@eleve.cg'],
        ['prenom' => 'Serge', 'nom' => 'Mboundzika', 'genre' => 'm', 'email' => 'serge@eleve.cg'],
        ['prenom' => 'Estelle', 'nom' => 'Ndinga', 'genre' => 'f', 'email' => 'estelle@eleve.cg'],
        ['prenom' => 'Patrice', 'nom' => 'Bidimbé', 'genre' => 'm', 'email' => 'patrice@eleve.cg'],
    ];

    private array $villes = ['Brazzaville', 'Pointe-Noire', 'Owando', 'Dolisie'];

    public function run(): void
    {
        $anneeScolaire = AnneeScolaire::where('active', true)->first();
        if (!$anneeScolaire) {
            $anneeScolaire = AnneeScolaire::first();
        }
        $classes = Classe::all();

        if (!$anneeScolaire || $classes->isEmpty()) {
            $this->command->error('❌ Année scolaire ou classes manquantes');
            return;
        }

        $this->command->info('🔄 Création de exactement 5 élèves...');

        $classeTest = $classes->firstWhere('nom', 'CE1 A');
        if (!$classeTest) {
            $classeTest = $classes->first();
        }

        $created = 0;
        foreach ($this->eleves as $data) {
            $classe = $classeTest;
            $user = User::where('email', $data['email'])->first();

            if (!$user) {
                $this->command->warn("⚠️ Pas d'utilisateur trouvé pour {$data['email']}, saut de l'étape...");
                continue;
            }

            $eleve = Eleve::updateOrCreate(
                ['email' => $data['email']],
                [
                    'user_id' => $user->id,
                    'nom' => $data['nom'],
                    'prenom' => $data['prenom'],
                    'matricule' => $data['email'] === 'mouana@eleve.cg' ? 'PSE13/25/A3' : Eleve::genererMatricule($data['nom']),
                    'date_naissance' => Carbon::now()->subYears(rand(6, 12)), // Âges école primaire
                    'lieu_naissance' => $this->villes[array_rand($this->villes)],
                    'genre' => $data['genre'],
                    'adresse' => rand(1, 100) . ' Rue de la Paix, ' . $this->villes[array_rand($this->villes)],
                    'telephone' => '+24206' . rand(1000000, 9999999),
                    'photo' => null,
                    'date_inscription' => $anneeScolaire->date_debut,
                    'statut' => true,
                ]
            );

            $user->assignRole('eleve');

            // Créer l'inscription active pour l'année en cours
            Inscription::updateOrCreate(
                [
                    'eleve_id' => $eleve->id,
                    'annee_scolaire_id' => $anneeScolaire->id,
                ],
                [
                    'classe_id' => $classe->id,
                    'date_inscription' => $anneeScolaire->date_debut,
                    'statut' => true,
                ]
            );

            // On ajoute aussi des inscriptions sur les années précédentes pour simuler le parcours complet
            $anciennesAnnees = AnneeScolaire::where('id', '!=', $anneeScolaire->id)->get();
            foreach ($anciennesAnnees as $aAnnee) {
                Inscription::updateOrCreate(
                    [
                        'eleve_id' => $eleve->id,
                        'annee_scolaire_id' => $aAnnee->id,
                    ],
                    [
                        'classe_id' => $classes->where('id', '!=', $classe->id)->first()?->id ?? $classe->id,
                        'date_inscription' => $aAnnee->date_debut,
                        'statut' => false, // ancienne inscription
                    ]
                );
            }

            $created++;
            $this->command->line("✅ Élève : {$data['prenom']} {$data['nom']} inscrit en {$classe->nom}");
        }

        $this->command->info("✅ Exactement {$created} élèves créés !");
    }
}