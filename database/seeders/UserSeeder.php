<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔄 Creating users (admin + linking for enseignants/eleves/parents)...');

        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@scolaire.cg',
            'password' => Hash::make('admin2024!'),
            'email_verified_at' => now(),
            'role' => 'administrateur',
            'is_active' => true,
        ]);
        $admin->assignRole('administrateur');
        $this->command->line('✅ Admin: admin@scolaire.cg / admin2024!');

        // Super Administrateur
        $superAdmin = User::create([
            'name' => 'Super Administrateur',
            'email' => 'superadmin@scolaire.cg',
            'password' => Hash::make('superadmin2024!'),
            'email_verified_at' => now(),
            'role' => 'administrateur',
            'is_active' => true,
        ]);
        $superAdmin->assignRole('administrateur');
        $this->command->line('✅ Super Admin: superadmin@scolaire.cg / superadmin2024!');

        // Users for EnseignantSeeder (first 2)
        $enseignants = [
            ['name' => 'Ndinga Mouélé', 'email' => 'ndinga@enseignant.cg'],
            ['name' => 'Bidimbé Lékolo', 'email' => 'bidimbe@enseignant.cg'],
        ];
        foreach ($enseignants as $ens) {
            $user = User::create([
                'name' => $ens['name'],
                'email' => $ens['email'],
'password' => Hash::make('enseignant2024!'),
                'email_verified_at' => now(),
                'role' => 'enseignant',
                'is_active' => true,
            ]);
            $user->assignRole('enseignant');
            $this->command->line("✅ Enseignant: {$ens['email']}");
        }

        // Users for EleveSeeder (first 2)
        $eleves = [
            ['name' => 'Mouana Pemba', 'email' => 'mouana@eleve.cg'],
            ['name' => 'Koubemba Ngoma', 'email' => 'koubemba@eleve.cg'],
        ];
        foreach ($eleves as $elv) {
            $user = User::create([
                'name' => $elv['name'],
                'email' => $elv['email'],
'password' => Hash::make('eleve2024!'),
                'email_verified_at' => now(),
                'role' => 'eleve',
                'is_active' => true,
            ]);
            $user->assignRole('eleve');
            $this->command->line("✅ Eleve: {$elv['email']}");
        }

        // Users for ParentEleveSeeder (first 3)
        $parents = [
            ['name' => 'Itoua Massoukou', 'email' => 'itoua@parent.cg'],
            ['name' => 'Moutou Ossibi', 'email' => 'moutou@parent.cg'],
            ['name' => 'Gombé Koumba', 'email' => 'gombe@parent.cg'],
        ];
        foreach ($parents as $par) {
            $user = User::create([
                'name' => $par['name'],
                'email' => $par['email'],
'password' => Hash::make('parent2024!'),
                'email_verified_at' => now(),
                'role' => 'parent',
                'is_active' => true,
            ]);
            $user->assignRole('parent');
            $this->command->line("✅ Parent: {$par['email']}");
        }

        $this->command->info('✅ UserSeeder complete! Total users created with roles.');
    }
}