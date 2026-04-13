<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EnseignantSeeder extends Seeder
{
    /**
     * Exactly 10 enseignants with Congolese names
     * First 2 link to UserSeeder enseignants
     */
    private array $enseignants = [
        ['prenom' => 'Ndinga', 'nom' => 'Mouélé', 'genre' => 'M', 'specialite' => 'Mathématiques', 'email' => 'ndinga@enseignant.cg'],
        ['prenom' => 'Bidimbé', 'nom' => 'Lékolo', 'genre' => 'F', 'specialite' => 'Français', 'email' => 'bidimbe@enseignant.cg'],
        ['prenom' => 'Kimbonda', 'nom' => 'Mboumba', 'genre' => 'M', 'specialite' => 'SVT', 'email' => 'kimbonda@enseignant.cg'],
        ['prenom' => 'Loubaki', 'nom' => 'Mboundzika', 'genre' => 'F', 'specialite' => 'Histoire', 'email' => 'loubaki@enseignant.cg'],
        ['prenom' => 'Pemba', 'nom' => 'Mouana', 'genre' => 'M', 'specialite' => 'Physique', 'email' => 'pemba@enseignant.cg'],
        ['prenom' => 'Ngoma', 'nom' => 'Koubemba', 'genre' => 'F', 'specialite' => 'Anglais', 'email' => 'ngoma@enseignant.cg'],
        ['prenom' => 'Massoukou', 'nom' => 'Itoua', 'genre' => 'M', 'specialite' => 'EPS', 'email' => 'massoukou@enseignant.cg'],
        ['prenom' => 'Ossibi', 'nom' => 'Moutou', 'genre' => 'M', 'specialite' => 'Arts', 'email' => 'ossibi@enseignant.cg'],
        ['prenom' => 'Koumba', 'nom' => 'Gombé', 'genre' => 'F', 'specialite' => 'Technologie', 'email' => 'koumba@enseignant.cg'],
        ['prenom' => 'Bissikabé', 'nom' => 'Nkoumou', 'genre' => 'M', 'specialite' => 'Musique', 'email' => 'bissikabe@enseignant.cg'],
    ];

    private array $villes = ['Brazzaville', 'Pointe-Noire', 'Dollo', 'Owando', 'Mossendjo', 'Nkayi', 'Madingou', 'Kinkala'];

    public function run(): void
    {
        $this->command->info('🔄 Creating exactly 10 enseignants...');

        $created = 0;
        foreach ($this->enseignants as $data) {
            // Link to user if exists
            $user = User::where('email', $data['email'])->first();
            $userId = $user?->id;

            $enseignant = Enseignant::create([
                'user_id' => $userId,
                // Auto-generate proper matricule via model (ENS-2024-N0001 format)
                'matricule' => Enseignant::genererMatricule($data['nom']),
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'genre' => $data['genre'],
                'date_naissance' => Carbon::now()->subYears(rand(30, 55)),
                'lieu_naissance' => $this->villes[array_rand($this->villes)],
                'telephone' => '+24206' . rand(1000000, 9999999),
                'email' => $data['email'],
                'adresse' => rand(1, 200) . ' Av. du Congo, ' . $this->villes[array_rand($this->villes)],
                'specialite' => $data['specialite'],
                'photo' => null,
                'statut' => true,
            ]);

            if ($userId) {
                $user = User::find($userId);
                $user->assignRole('enseignant');
                $this->command->line("✅ Assigned 'enseignant' role to user");
            }

            $created++;
            $this->command->line("✅ {$data['prenom']} {$data['nom']} ({$data['specialite']})" . ($userId ? ' [linked user]' : ''));
        }

        $this->command->info("✅ Exactly {$created} enseignants created!");
    }
}