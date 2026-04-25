<?php
$dir = new RecursiveDirectoryIterator('c:/xampp/htdocs/ScolairesParcours/scolaire-parcour/app');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach($files as $file) {
    if (in_array(basename($file[0]), ['.', '..'])) continue;
    $filepath = $file[0];
    
    $content = file_get_contents($filepath);
    $original = $content;
    
    $content = str_replace("Inscription::where(", "Inscription::query()->where(", $content);
    $content = str_replace("->where('statut', true)", "->whereIn('statut', ['inscrit', 'active', '1', 1, true])", $content);
    
    // Also fix Dynamic properties like "$classe->eleves_count =" ? That's harder with basic str_replace.
    // Let's just fix the Inscription and statut issues first.
    
    if ($content !== $original) {
        file_put_contents($filepath, $content);
        echo "Fixed: $filepath\n";
    }
}
echo "Done checking all PHP files.\n";
