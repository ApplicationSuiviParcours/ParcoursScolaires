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
     * Exactly 5 parents with Congolese names
     */
    private array $parents = [
        ['prenom' => 'Itoua', 'nom' => 'Massoukou', 'genre' => 'm', 'profession' => 'Commerçant', 'email' => 'itoua@parent.cg'],
        ['prenom' => 'Moutou', 'nom' => 'Ossibi', 'genre' => 'm', 'profession' => 'Fonctionnaire', 'email' => 'moutou@parent.cg'],
        ['prenom' => 'Gombé', 'nom' => 'Koumba', 'genre' => 'f', 'profession' => 'Enseignante', 'email' => 'gombe@parent.cg'],
        ['prenom' => 'Bissikabé', 'nom' => 'Nkoumou', 'genre' => 'f', 'profession' => 'Médecin', 'email' => 'bissikabe@parent.cg'],
        ['prenom' => 'Lékolo', 'nom' => 'Bidimbé', 'genre' => 'f', 'profession' => 'Avocat', 'email' => 'lekolo@parent.cg'],
    ];

    private array $villes = ['Brazzaville', 'Pointe-Noire', 'Owando', 'Dolisie'];

    public function run(): void
    {
        $eleves = Eleve::all();

        $this->command->info('🔄 Création de exactement 5 parents...');

        $created = 0;
        foreach ($this->parents as $index => $data) {
            $user = User::where('email', $data['email'])->first();
            
            if (!$user) {
                $this->command->warn("⚠️ Pas d'utilisateur trouvé pour {$data['email']}, saut de l'étape...");
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
                    'adresse' => rand(1, 150) . ' Boulevard de l\'Indépendance, ' . $this->villes[array_rand($this->villes)],
                    'date_naissance' => Carbon::now()->subYears(rand(35, 50)),
                    'lieu_naissance' => $this->villes[array_rand($this->villes)],
                    'statut' => true,
                    'notes' => 'Parent impliqué dans le suivi de scolarité',
                ]
            );

            $user->assignRole('parent');

            // Associer ce parent à un élève de manière ordonnée pour les tests
            if ($eleves->isNotEmpty()) {
                // Associer l'élève à l'index correspondant ou aléatoire
                $eleve = $eleves->get($index % $eleves->count());
                DB::table('eleve_parents')->updateOrInsert(
                    [
                        'parent_eleve_id' => $parent->id,
                        'eleve_id' => $eleve->id,
                    ],
                    [
                        'lien_parental' => $data['genre'] === 'f' ? 'Mère' : 'Père',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            $created++;
            $this->command->line("✅ Parent : {$data['prenom']} {$data['nom']} ({$data['profession']})");
        }

        $this->command->info("✅ Exactement {$created} parents créés !");
    }
}
