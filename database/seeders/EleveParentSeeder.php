<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eleve;
use App\Models\ParentEleve;
use Illuminate\Support\Facades\DB;

class EleveParentSeeder extends Seeder
{
    public function run(): void
    {
        $eleves = Eleve::all();
        $parents = ParentEleve::all();

        if ($eleves->isEmpty() || $parents->isEmpty()) {
            $this->command->error('❌ Élèves ou parents manquants.');
            return;
        }

        $this->command->info('🔄 Création des liaisons parents-élèves...');

        $created = 0;
        foreach ($eleves as $index => $eleve) {
            $parent = $parents->get($index % $parents->count());

            DB::table('eleve_parents')->updateOrInsert(
                [
                    'eleve_id' => $eleve->id,
                    'parent_eleve_id' => $parent->id,
                ],
                [
                    'lien_parental' => $parent->genre === 'f' || $parent->genre === 'F' ? 'Mère' : 'Père',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $created++;
            $this->command->line("✅ Liaison : {$eleve->prenom} {$eleve->nom} ↔ {$parent->prenom} {$parent->nom}");
        }

        $this->command->info("✅ {$created} associations parents-élèves créées !");
    }
}