<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnneeScolaire;
use Carbon\Carbon;

class AnneeScolaireSeeder extends Seeder
{
    /**
     * Exactly 10 années scolaires
     */
    public function run(): void
    {
        $annees = [
            ['nom' => '2016-2017', 'date_debut' => '2016-09-01', 'date_fin' => '2017-08-31', 'active' => false],
            ['nom' => '2017-2018', 'date_debut' => '2017-09-01', 'date_fin' => '2018-08-31', 'active' => false],
            ['nom' => '2018-2019', 'date_debut' => '2018-09-01', 'date_fin' => '2019-08-31', 'active' => false],
            ['nom' => '2019-2020', 'date_debut' => '2019-09-01', 'date_fin' => '2020-08-31', 'active' => false],
            ['nom' => '2020-2021', 'date_debut' => '2020-09-01', 'date_fin' => '2021-08-31', 'active' => false],
            ['nom' => '2021-2022', 'date_debut' => '2021-09-01', 'date_fin' => '2022-08-31', 'active' => false],
            ['nom' => '2022-2023', 'date_debut' => '2022-09-01', 'date_fin' => '2023-08-31', 'active' => false],
            ['nom' => '2023-2024', 'date_debut' => '2023-09-01', 'date_fin' => '2024-08-31', 'active' => false],
            ['nom' => '2024-2025', 'date_debut' => '2024-09-01', 'date_fin' => '2025-08-31', 'active' => true],
            ['nom' => '2025-2026', 'date_debut' => '2025-09-01', 'date_fin' => '2026-08-31', 'active' => false],
        ];

        foreach ($annees as $annee) {
            AnneeScolaire::firstOrCreate(
                ['nom' => $annee['nom']],
                array_merge($annee, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        $this->command->info('✅ Exactly 10 années scolaires created (2024-2025 active)');
    }
}