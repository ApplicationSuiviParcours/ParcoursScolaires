<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParentEleve;
use App\Models\User;
use App\Models\Eleve;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ParentEleveSeeder extends Seeder
{
    /**
     * Exactly 10 parents with Congolese names
     * Link first 3 to UserSeeder parents by email
     */
    private array $parents = [
        ['prenom' => 'Itoua', 'nom' => 'Massoukou', 'genre' => 'M', 'profession' => 'Commerçant', 'email' => 'itoua@parent.cg'],
        ['prenom' => 'Moutou', 'nom' => 'Ossibi', 'genre' => 'M', 'profession' => 'Fonctionnaire', 'email' => 'moutou@parent.cg'],
        ['prenom' => 'Gombé', 'nom' => 'Koumba', 'genre' => 'F', 'profession' => 'Enseignante', 'email' => 'gombe@parent.cg'],
        ['prenom' => 'Bissikabé', 'nom' => 'Nkoumou', 'genre' => 'F', 'profession' => 'Médecin', 'email' => 'bissikabe@parent.cg'],
        ['prenom' => 'Lékolo', 'nom' => 'Bidimbé', 'genre' => 'F', 'profession' => 'Avocat', 'email' => 'lekolo@parent.cg'],
        ['prenom' => 'Mouélé', 'nom' => 'Ndinga', 'genre' => 'M', 'profession' => 'Ingénieur', 'email' => 'moue@parent.cg'],
        ['prenom' => 'Kimbonda', 'nom' => 'Mboundzika', 'genre' => 'M', 'profession' => 'Agriculteur', 'email' => 'kimbonda@parent.cg'],
        ['prenom' => 'Pemba', 'nom' => 'Loubaki', 'genre' => 'F', 'profession' => 'Comptable', 'email' => 'pemba@parent.cg'],
        ['prenom' => 'Ngoma', 'nom' => 'Serge', 'genre' => 'M', 'profession' => 'Entrepreneur', 'email' => 'ngoma@parent.cg'],
        ['prenom' => 'Estelle', 'nom' => 'Thérèse', 'genre' => 'F', 'profession' => 'Infirmière', 'email' => 'estelle@parent.cg'],
    ];

    private array $villes = ['Brazzaville', 'Pointe-Noire', 'Nkayi', 'Madingou', 'Kinkala'];

    public function run(): void
    {
        $eleves = Eleve::all();
        if ($eleves->isEmpty()) {
            $this->command->warn('⚠️ No eleves found');
        }

        $this->command->info('🔄 Creating exactly 10 parents...');

        $created = 0;
        foreach ($this->parents as $data) {
            $user = User::where('email', $data['email'])->first();
            
            if (!$user) {
                $this->command->warn("⚠️ No user for {$data['email']}, skipping...");
                continue;
            }

            $parent = ParentEleve::updateOrCreate(
                ['email' => $data['email']],
                [
                    'user_id' => $user->id,
                    'nom' => $data['nom'],
                    'prenom' => $data['prenom'],
                    'matricule' => ParentEleve::genererMatricule($data['nom']),
                    'genre' => $data['genre'],
                    'profession' => $data['profession'],
                    'telephone' => '+24206' . rand(1000000, 9999999),
                    'adresse' => rand(1, 150) . ' Bd du 15 Août, ' . $this->villes[array_rand($this->villes)],
                    'date_naissance' => Carbon::now()->subYears(rand(35, 55)),
                    'lieu_naissance' => $this->villes[array_rand($this->villes)],
                    'statut' => true,
                    'notes' => 'Parent très impliqué',
                ]
            );

            $user->assignRole('parent');

            // Associate to 1-2 eleves
            if ($eleves->isNotEmpty()) {
                $numChildren = rand(1, 2);
                $selectedEleves = $eleves->random($numChildren);
                foreach ($selectedEleves as $eleve) {
                    DB::table('eleve_parents')->updateOrInsert(
                        [
                            'parent_eleve_id' => $parent->id,
                            'eleve_id' => $eleve->id,
                        ],
                        [
                            'lien_parental' => $data['genre'] === 'F' ? 'Mère' : 'Père',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }

            $created++;
            $this->command->line("✅ {$data['prenom']} {$data['nom']} ({$data['profession']}) [linked user]");
        }

        $this->command->info("✅ Exactly {$created} parents created!");
    }
}
