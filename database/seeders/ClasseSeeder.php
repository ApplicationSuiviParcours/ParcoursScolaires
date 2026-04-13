<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Matiere;
use Illuminate\Support\Facades\DB;

class ClasseSeeder extends Seeder
{
    /**
     * Exactly 9 classes across different school levels (removed Licence1)
     */
    private array $classes = [
        ['nom' => 'A', 'niveau' => 'P1', 'serie' => null, 'capacite' => 25],
        ['nom' => 'A', 'niveau' => 'CP1', 'serie' => null, 'capacite' => 35],
        ['nom' => 'A', 'niveau' => 'CE1', 'serie' => null, 'capacite' => 35],
        ['nom' => 'A', 'niveau' => 'CM2', 'serie' => null, 'capacite' => 35],
        ['nom' => 'A', 'niveau' => '6ème', 'serie' => null, 'capacite' => 40],
        ['nom' => 'A', 'niveau' => '3ème', 'serie' => null, 'capacite' => 30],
        ['nom' => 'A', 'niveau' => 'Seconde', 'serie' => 'A', 'capacite' => 35],
        ['nom' => 'A', 'niveau' => 'Première', 'serie' => 'C', 'capacite' => 30],
        ['nom' => 'A', 'niveau' => 'Terminale', 'serie' => 'D', 'capacite' => 25],
    ];

    public function run(): void
    {
        $anneeScolaire = AnneeScolaire::where('active', true)->first() ?? AnneeScolaire::first();
        if (!$anneeScolaire) {
            $this->command->error('❌ No AnneeScolaire found');
            return;
        }

        $matieres = Matiere::all();
        if ($matieres->isEmpty()) {
            $this->command->warn('⚠️ No matieres found');
        }

        $this->command->info('🔄 Creating 9 school classes...');

        foreach ($this->classes as $data) {
            $classe = Classe::create([
                'nom' => $data['nom'],
                'niveau' => $data['niveau'],
                'serie' => $data['serie'],
                'capacite' => $data['capacite'],
                'annee_scolaire_id' => $anneeScolaire->id,
            ]);

            $this->command->line("✅ {$classe->nom_complet}");

            // Add 3-5 matieres per class
            $matieresCount = min(rand(3, 5), $matieres->count());
            $selectedMatieres = $matieres->random($matieresCount);
            foreach ($selectedMatieres as $matiere) {
                \App\Models\ClasseMatiere::create([
                    'classe_id' => $classe->id,
                    'matiere_id' => $matiere->id,
                    'coefficient' => rand(1, 5),
                ]);
            }
        }

        $total = Classe::count();
        $this->command->info("✅ Exactly {$total} classes created for {$anneeScolaire->nom}");
    }
}