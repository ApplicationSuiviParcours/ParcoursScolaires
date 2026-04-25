<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$eleve = \App\Models\Eleve::whereNotNull('user_id')->first();
$eleve->load(['inscriptionActive.classe.anneeScolaire', 'classe']);
$classe = $eleve->inscriptionActive?->classe ?? $eleve->classe;
$annee = $eleve->inscriptionActive?->anneeScolaire ?? ($classe?->anneeScolaire);

$data = [
    'eleve' => new \App\Http\Resources\EleveResource($eleve),
    'classe' => $classe ? new \App\Http\Resources\ClasseResource($classe) : null,
];

echo json_encode($data, JSON_PRETTY_PRINT);
