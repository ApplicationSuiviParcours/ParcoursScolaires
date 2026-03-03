<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ParentEleve;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            AnneeScolaireSeeder::class,
            MatiereSeeder::class,
            ClasseSeeder::class,
            ClasseMatiereSeeder::class,
            EleveSeeder::class,
            ParentEleveSeeder::class,
            EleveParentSeeder::class,
            EnseignantSeeder::class,
            InscriptionSeeder::class,
            ReinscriptionSeeder::class,
            EnseignantMatiereClasseSeeder::class,
            EvaluationSeeder::class,
            NoteSeeder::class,
            AbsenceSeeder::class,
            BulletinSeeder::class,
            EmploiDuTempsSeeder::class,
        ]);
    }
}
