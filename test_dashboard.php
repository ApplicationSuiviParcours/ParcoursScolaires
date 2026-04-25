<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::find(13);
Illuminate\Support\Facades\Auth::login($user);
$request = Illuminate\Http\Request::create('/api/eleve/dashboard', 'GET');
$controller = app(App\Http\Controllers\Api\Eleve\DashboardController::class);
$response = $controller->index($request);
echo $response->getContent();
