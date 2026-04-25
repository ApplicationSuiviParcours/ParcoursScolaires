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
            'photo' => 'https://i.pravatar.cc/150?u=admin',
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
            'photo' => 'https://i.pravatar.cc/150?u=superadmin',
        ]);
        $superAdmin->assignRole('administrateur');
        $this->command->line('✅ Super Admin: superadmin@scolaire.cg / superadmin2024!');

        // Users for EnseignantSeeder (All 10)
        $enseignantEmails = [
            'ndinga@enseignant.cg', 'bidimbe@enseignant.cg', 'kimbonda@enseignant.cg',
            'loubaki@enseignant.cg', 'pemba@enseignant.cg', 'ngoma@enseignant.cg',
            'massoukou@enseignant.cg', 'ossibi@enseignant.cg', 'koumba@enseignant.cg',
            'bissikabe@enseignant.cg'
        ];
        foreach ($enseignantEmails as $email) {
            $name = ucwords(explode('@', $email)[0]);
            $user = User::firstOrCreate(['email' => $email], [
                'name' => $name,
                'password' => Hash::make('enseignant2024!'),
                'email_verified_at' => now(),
                'role' => 'enseignant',
                'is_active' => true,
            ]);
            $user->assignRole('enseignant');
            $this->command->line("✅ Enseignant: {$email}");
        }

        // Users for EleveSeeder (All 10)
        $eleveEmails = [
            'mouana@eleve.cg', 'koubemba@eleve.cg', 'serge@eleve.cg', 'estelle@eleve.cg',
            'patrice@eleve.cg', 'martine@eleve.cg', 'joel@eleve.cg', 'solange@eleve.cg',
            'aristide@eleve.cg', 'therese@eleve.cg'
        ];
        foreach ($eleveEmails as $email) {
            $name = ucwords(explode('@', $email)[0]);
            $user = User::firstOrCreate(['email' => $email], [
                'name' => $name,
                'password' => Hash::make('eleve2024!'),
                'email_verified_at' => now(),
                'role' => 'eleve',
                'is_active' => true,
            ]);
            $user->assignRole('eleve');
            $this->command->line("✅ Eleve: {$email}");
        }

        // Users for ParentEleveSeeder (All 10)
        $parentEmails = [
            'itoua@parent.cg', 'moutou@parent.cg', 'gombe@parent.cg', 'bissikabe@parent.cg',
            'lekolo@parent.cg', 'moue@parent.cg', 'kimbonda@parent.cg', 'pemba@parent.cg',
            'ngoma@parent.cg', 'estelle@parent.cg'
        ];
        foreach ($parentEmails as $email) {
            $name = ucwords(explode('@', $email)[0]);
            $user = User::firstOrCreate(['email' => $email], [
                'name' => $name,
                'password' => Hash::make('parent2024!'),
                'email_verified_at' => now(),
                'role' => 'parent',
                'is_active' => true,
            ]);
            $user->assignRole('parent');
            $this->command->line("✅ Parent: {$email}");
        }

        $this->command->info('✅ UserSeeder complete! All entities have user accounts with roles.');
    }
}