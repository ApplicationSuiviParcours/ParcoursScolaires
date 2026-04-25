<?php
$filepath = 'c:/xampp/htdocs/ScolairesParcours/scolaire-parcour/app/Http/Controllers/Admin/ClasseController.php';
$content = file_get_contents($filepath);
$content = str_replace("Inscription::where", "Inscription::query()->where", $content);
$content = str_replace("->where('statut', true)", "->whereIn('statut', ['inscrit', 'active', '1', 1, true])", $content);
file_put_contents($filepath, $content);
echo "Replaced properly";
