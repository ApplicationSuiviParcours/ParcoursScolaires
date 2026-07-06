<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enseignant;
use App\Models\User;
use Carbon\Carbon;

class EnseignantSeeder extends Seeder
{
    /**
     * Exactly 5 enseignants with Congolese names
     */
    private array $enseignants = [
        ['prenom' => 'Ndinga', 'nom' => 'Mouélé', 'genre' => 'm', 'specialite' => 'Mathématiques', 'email' => 'ndinga@enseignant.cg'],
        ['prenom' => 'Bidimbé', 'nom' => 'Lékolo', 'genre' => 'f', 'specialite' => 'Français', 'email' => 'bidimbe@enseignant.cg'],
        ['prenom' => 'Kimbonda', 'nom' => 'Mboumba', 'genre' => 'm', 'specialite' => 'Sciences SVT', 'email' => 'kimbonda@enseignant.cg'],
        ['prenom' => 'Loubaki', 'nom' => 'Mboundzika', 'genre' => 'f', 'specialite' => 'Histoire-Géographie', 'email' => 'loubaki@enseignant.cg'],
        ['prenom' => 'Pemba', 'nom' => 'Mouana', 'genre' => 'm', 'specialite' => 'Physique-Chimie', 'email' => 'pemba@enseignant.cg'],
    ];

    private array $villes = ['Brazzaville', 'Pointe-Noire', 'Owando', 'Dolisie'];

    public function run(): void
    {
        $this->command->info('🔄 Création de exactement 5 enseignants...');

        $created = 0;
        foreach ($this->enseignants as $data) {
            $user = User::where('email', $data['email'])->first();
            
            if (!$user) {
                $this->command->warn("⚠️ Pas d'utilisateur trouvé pour {$data['email']}, saut de l'étape...");
                continue;
            }

            $enseignant = Enseignant::updateOrCreate(
                ['email' => $data['email']],
                [
                    'user_id' => $user->id,
                    'matricule' => Enseignant::genererMatricule($data['nom']),
                    'nom' => $data['nom'],
                    'prenom' => $data['prenom'],
                    'genre' => $data['genre'],
                    'date_naissance' => Carbon::now()->subYears(rand(28, 50)),
                    'lieu_naissance' => $this->villes[array_rand($this->villes)],
                    'telephone' => '+24206' . rand(1000000, 9999999),
                    'adresse' => rand(1, 200) . ' Avenue de la République, ' . $this->villes[array_rand($this->villes)],
                    'specialite' => $data['specialite'],
                    'photo' => null,
                    'statut' => true,
                ]
            );

            $user->assignRole('enseignant');
            $created++;
            $this->command->line("✅ Enseignant : {$data['prenom']} {$data['nom']} ({$data['specialite']})");
        }

        $this->command->info("✅ Exactement {$created} enseignants créés !");
    }
}