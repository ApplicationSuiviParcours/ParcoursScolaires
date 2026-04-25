<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Inscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class EleveSeeder extends Seeder
{
    /**
     * Exactly 10 élèves with Congolese names
     * Link first 2 to UserSeeder eleves by email
     */
    private array $eleves = [
        ['prenom' => 'Mouana', 'nom' => 'Pemba', 'genre' => 'M', 'email' => 'mouana@eleve.cg'],
        ['prenom' => 'Koubemba', 'nom' => 'Ngoma', 'genre' => 'F', 'email' => 'koubemba@eleve.cg'],
        ['prenom' => 'Serge', 'nom' => 'Mboundzika', 'genre' => 'M', 'email' => 'serge@eleve.cg'],
        ['prenom' => 'Estelle', 'nom' => 'Ndinga', 'genre' => 'F', 'email' => 'estelle@eleve.cg'],
        ['prenom' => 'Patrice', 'nom' => 'Bidimbé', 'genre' => 'M', 'email' => 'patrice@eleve.cg'],
        ['prenom' => 'Martine', 'nom' => 'Kimbonda', 'genre' => 'F', 'email' => 'martine@eleve.cg'],
        ['prenom' => 'Joël', 'nom' => 'Loubaki', 'genre' => 'M', 'email' => 'joel@eleve.cg'],
        ['prenom' => 'Solange', 'nom' => 'Mboumba', 'genre' => 'F', 'email' => 'solange@eleve.cg'],
        ['prenom' => 'Aristide', 'nom' => 'Itoua', 'genre' => 'M', 'email' => 'aristide@eleve.cg'],
        ['prenom' => 'Thérèse', 'nom' => 'Moutou', 'genre' => 'F', 'email' => 'therese@eleve.cg'],
    ];

    private array $villes = ['Brazzaville', 'Pointe-Noire', 'Dollo', 'Owando', 'Mossendjo'];

    public function run(): void
    {
        $anneeScolaire = AnneeScolaire::where('active', true)->first();
        $classes = Classe::all();

        if (!$anneeScolaire || $classes->isEmpty()) {
            $this->command->error('❌ Missing AnneeScolaire or Classe');
            return;
        }

        $this->command->info('🔄 Creating exactly 10 élèves...');

        $created = 0;
        foreach ($this->eleves as $data) {
            $classe = $classes->random();
            $user = User::where('email', $data['email'])->first();

            if (!$user) {
                $this->command->warn("⚠️ No user for {$data['email']}, skipping...");
                continue;
            }

            $eleve = Eleve::updateOrCreate(
                ['email' => $data['email']],
                [
                    'user_id' => $user->id,
                    'nom' => $data['nom'],
                    'prenom' => $data['prenom'],
                    'matricule' => Eleve::genererMatricule($data['nom']),
                    'date_naissance' => Carbon::now()->subYears(rand(10, 18)),
                    'lieu_naissance' => $this->villes[array_rand($this->villes)],
                    'genre' => $data['genre'],
                    'adresse' => rand(1, 100) . ' Rue du 13 Août, ' . $this->villes[array_rand($this->villes)],
                    'telephone' => '+24206' . rand(1000000, 9999999),
                    'photo' => null,
                    'date_inscription' => $anneeScolaire->date_debut,
                    'statut' => true,
                ]
            );

            $user->assignRole('eleve');

            // Create inscription
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

            $created++;
            $this->command->line("✅ {$data['prenom']} {$data['nom']} in {$classe->nom_complet} [linked user]");
        }

        $this->command->info("✅ Exactly {$created} élèves created!");
    }
}