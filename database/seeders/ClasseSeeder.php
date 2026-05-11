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
     * Classes organisées par niveau, avec des sections distinctes (A, B, C...)
     * Le champ 'nom' représente la section (A, B, C), le champ 'niveau' représente le niveau.
     * nom_complet = niveau + ' ' + nom → ex: "6ème A", "6ème B", "CE1 A", etc.
     */
    private array $classes = [
        // Primaire
        ['nom' => 'PS A',       'niveau' => 'PS',        'serie' => null, 'capacite' => 25],
        ['nom' => 'PS B',       'niveau' => 'PS',        'serie' => null, 'capacite' => 25],
        ['nom' => 'CP A',       'niveau' => 'CP',        'serie' => null, 'capacite' => 35],
        ['nom' => 'CP B',       'niveau' => 'CP',        'serie' => null, 'capacite' => 35],
        ['nom' => 'CE1 A',      'niveau' => 'CE1',       'serie' => null, 'capacite' => 35],
        ['nom' => 'CE1 B',      'niveau' => 'CE1',       'serie' => null, 'capacite' => 35],
        ['nom' => 'CM2 A',      'niveau' => 'CM2',       'serie' => null, 'capacite' => 35],

        // Collège
        ['nom' => '6ème A',     'niveau' => '6ème',      'serie' => null, 'capacite' => 40],
        ['nom' => '6ème B',     'niveau' => '6ème',      'serie' => null, 'capacite' => 40],
        ['nom' => '5ème A',     'niveau' => '5ème',      'serie' => null, 'capacite' => 38],
        ['nom' => '4ème A',     'niveau' => '4ème',      'serie' => null, 'capacite' => 36],
        ['nom' => '3ème A',     'niveau' => '3ème',      'serie' => null, 'capacite' => 30],
        ['nom' => '3ème B',     'niveau' => '3ème',      'serie' => null, 'capacite' => 30],

        // Lycée
        ['nom' => 'Seconde A',       'niveau' => 'Seconde',   'serie' => null, 'capacite' => 35],
        ['nom' => 'Première A',      'niveau' => 'Première',  'serie' => 'C',  'capacite' => 30],
        ['nom' => 'Première B',      'niveau' => 'Première',  'serie' => 'D',  'capacite' => 30],
        ['nom' => 'Terminale A',     'niveau' => 'Terminale', 'serie' => 'C',  'capacite' => 25],
        ['nom' => 'Terminale B',     'niveau' => 'Terminale', 'serie' => 'D',  'capacite' => 25],
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

        $this->command->info('🔄 Creating school classes...');

        foreach ($this->classes as $data) {
            $classe = Classe::create([
                'nom'              => $data['nom'],
                'niveau'           => $data['niveau'],
                'serie'            => $data['serie'],
                'capacite'         => $data['capacite'],
                'annee_scolaire_id' => $anneeScolaire->id,
            ]);

            $this->command->line("✅ {$classe->nom_complet}");

            // Add 4-6 matieres per class
            if ($matieres->isNotEmpty()) {
                $matieresCount = min(rand(4, 6), $matieres->count());
                $selectedMatieres = $matieres->random($matieresCount);
                foreach ($selectedMatieres as $matiere) {
                    \App\Models\ClasseMatiere::create([
                        'classe_id'   => $classe->id,
                        'matiere_id'  => $matiere->id,
                        'coefficient' => rand(1, 5),
                    ]);
                }
            }
        }

        $total = Classe::count();
        $this->command->info("✅ {$total} classes created for {$anneeScolaire->nom}");
    }
}