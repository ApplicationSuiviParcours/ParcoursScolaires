<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matiere;
use Illuminate\Support\Str;

class MatiereSeeder extends Seeder
{
    /**
     * Exactly 10 matières principales for all levels
     */
    private array $matieres = [
        ['nom' => 'Français', 'coefficient' => 5, 'description' => 'Langue et littérature'],
        ['nom' => 'Mathématiques', 'coefficient' => 5, 'description' => 'Arithmétique et géométrie'],
        ['nom' => 'Sciences (SVT)', 'coefficient' => 4, 'description' => 'Sciences de la vie'],
        ['nom' => 'Histoire-Géographie', 'coefficient' => 3, 'description' => 'Histoire et géographie'],
        ['nom' => 'Physique-Chimie', 'coefficient' => 4, 'description' => 'Sciences physiques'],
        ['nom' => 'Anglais', 'coefficient' => 3, 'description' => 'Langue vivante 1'],
        ['nom' => 'Éducation Physique (EPS)', 'coefficient' => 2, 'description' => 'Sport et santé'],
        ['nom' => 'Arts Plastiques', 'coefficient' => 2, 'description' => 'Expression artistique'],
        ['nom' => 'Technologie', 'coefficient' => 3, 'description' => 'Technologie et informatique'],
        ['nom' => 'Musique', 'coefficient' => 2, 'description' => 'Éducation musicale'],
    ];

    private function generateCode(string $nom): string
    {
        $slug = Str::slug($nom);
        $clean = str_replace(['-', '_', '(', ')', '/', '–', '&'], '', $slug);
        return strtoupper(substr($clean, 0, 4) ?: 'MAT');
    }

    public function run(): void
    {
        $this->command->info('🔄 Création de exactement 10 matières (firstOrCreate)...');

        $created = 0;
        foreach ($this->matieres as $data) {
            $code = $this->generateCode($data['nom']);
            Matiere::create([
                'nom' => $data['nom'],
                'code' => $code,
                'description' => $data['description'],
                'coefficient' => $data['coefficient'],
            ]);
            $this->command->line("  {$code} - {$data['nom']} (coeff {$data['coefficient']})");
            $created++;
        }

        $this->command->info("\n✅ Exactly {$created} matières créées!");
    }
}