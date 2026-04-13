<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "ADMIN: " . \App\Models\User::where('email', 'admin@ecole.com')->first()?->email . "\n";
echo "ELEVE: " . \App\Models\Eleve::first()?->matricule . "\n";
echo "ENSEIGNANT: " . \App\Models\Enseignant::first()?->matricule . "\n";
echo "PARENT: " . \App\Models\ParentEleve::first()?->matricule . "\n";
