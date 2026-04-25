<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$eleves = \App\Models\Eleve::whereNotNull('user_id')->get();
$missing = 0;
foreach($eleves as $e) {
    if (!$e->inscriptionActive && !$e->classe) {
        $missing++;
    }
}
echo "Missing: $missing";
