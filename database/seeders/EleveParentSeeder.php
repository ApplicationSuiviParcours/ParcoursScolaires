<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleve;
use App\Models\ParentEleve;
use Illuminate\Support\Facades\DB;

class EleveParentSeeder extends Seeder
{
    /**
     * Exactly 10 eleve-parent associations
     */
    public function run(): void
    {
        $eleves = Eleve::take(10)->get();
        $parents = ParentEleve::take(10)->get();

        if ($eleves->isEmpty() || $parents->isEmpty()) {
            $this->command->error('❌ Need 10 eleves and parents first');
            return;
        }

        $this->command->info('🔄 Creating exactly 10 eleve-parent associations...');

        $created = 0;
        for ($i = 0; $i < 10; $i++) {
            $eleve = $eleves[$i % 10];
            $parent = $parents[$i % 10];

            DB::table('eleve_parents')->updateOrInsert(
                [
                    'eleve_id' => $eleve->id,
                    'parent_eleve_id' => $parent->id,
                ],
                [
                    'lien_parental' => $parent->genre === 'F' ? 'Mère' : 'Père',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $created++;
            $this->command->line("✅ {$eleve->prenom} {$eleve->nom} - {$parent->prenom} {$parent->nom}");
        }

        $this->command->info("✅ Exactly {$created} associations created!");
    }
}