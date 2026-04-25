<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AnneeScolaireSeeder;
use Database\Seeders\MatiereSeeder;
use Database\Seeders\ClasseSeeder;
use Database\Seeders\ClasseMatiereSeeder;
use Database\Seeders\EleveSeeder;
use Database\Seeders\ParentEleveSeeder;
use Database\Seeders\EleveParentSeeder;
use Database\Seeders\EnseignantSeeder;
use Database\Seeders\InscriptionSeeder;
use Database\Seeders\ReinscriptionSeeder;
use Database\Seeders\EnseignantMatiereClasseSeeder;
use Database\Seeders\EvaluationSeeder;
use Database\Seeders\NoteSeeder;
use Database\Seeders\AbsenceSeeder;
use Database\Seeders\BulletinSeeder;
use Database\Seeders\EmploiDuTempsSeeder;
use Database\Seeders\EnsureUserDataSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
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
            EnsureUserDataSeeder::class,
        ]);
        // Supprimé : $this->call(UserSeeder::class) en double
    }
}