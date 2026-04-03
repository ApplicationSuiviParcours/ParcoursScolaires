<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (\App\Models\User::all() as $user) {
    if (!$user->roles->first()) {
        // Find profile type
        $newRole = null;
        if ($user->enseignant) {
            $newRole = 'enseignant';
        } elseif ($user->eleve) {
            $newRole = 'eleve';
        } elseif ($user->parentEleve) {
            $newRole = 'parent';
        }

        if ($newRole) {
            $user->update(['role' => $newRole]);
            $user->assignRole($newRole); // Assign spatie role too!
            echo "User {$user->id} synced missing role to: {$newRole}\n";
        } elseif ($user->role === 'enseignant') {
            // Nullify the incorrect default so it doesn't show randomly
            $user->update(['role' => null]);
            echo "User {$user->id} had incorrect default Enseignant, nullified\n";
        }
    }
}
