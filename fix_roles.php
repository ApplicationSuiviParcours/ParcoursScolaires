<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (\App\Models\User::all() as $user) {
    $primaryRole = $user->roles->first()?->name;
    if ($primaryRole) {
        $user->update(['role' => $primaryRole]);
        echo "User {$user->id} ({$user->name}) updated to {$primaryRole}" . PHP_EOL;
    } else {
        echo "User {$user->id} ({$user->name}) has NO spatie role" . PHP_EOL;
    }
}
