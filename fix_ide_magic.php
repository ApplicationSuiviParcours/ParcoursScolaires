<?php
$dir = new RecursiveDirectoryIterator('c:/xampp/htdocs/ScolairesParcours/scolaire-parcour/app');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

$patterns = [
    '/([A-Z][a-zA-Z0-9_]*)::where\(/',
    '/([A-Z][a-zA-Z0-9_]*)::whereHas\(/',
    '/([A-Z][a-zA-Z0-9_]*)::whereDate\(/',
    '/([A-Z][a-zA-Z0-9_]*)::whereIn\(/',
    '/([A-Z][a-zA-Z0-9_]*)::whereNotNull\(/',
    '/([A-Z][a-zA-Z0-9_]*)::whereNull\(/',
    '/([A-Z][a-zA-Z0-9_]*)::with\(/',
    '/([A-Z][a-zA-Z0-9_]*)::orderBy\(/',
    '/([A-Z][a-zA-Z0-9_]*)::latest\(/',
];
$replacements = [
    '$1::query()->where(',
    '$1::query()->whereHas(',
    '$1::query()->whereDate(',
    '$1::query()->whereIn(',
    '$1::query()->whereNotNull(',
    '$1::query()->whereNull(',
    '$1::query()->with(',
    '$1::query()->orderBy(',
    '$1::query()->latest(',
];

foreach($files as $file) {
    if (in_array(basename($file[0]), ['.', '..'])) continue;
    $filepath = $file[0];
    
    $content = file_get_contents($filepath);
    $original = $content;
    
    // Process replacements
    $content = preg_replace($patterns, $replacements, $content);
    
    // Avoid double query()->query() if it accidentally replaces something that already had it, or classes that are actually facades.
    // Facades like DB::where, Route::where are fine, but let's be careful.
    // Wait, DB::query()->where() is not needed, DB::table()->where() is used.
    // Let's avoid DB, Route, Storage, Log, Hash, Crypt, Auth, Config, Cache, Session, Gate, Event, Mail, etc.
    $facades = ['DB', 'Route', 'Storage', 'Log', 'Hash', 'Auth', 'Config', 'Cache', 'Session', 'Gate', 'Event', 'Mail', 'Schema', 'View'];
    foreach ($facades as $facade) {
        $content = str_replace($facade . '::query()->', $facade . '::', $content);
    }
    
    if ($content !== $original) {
        file_put_contents($filepath, $content);
        echo "Fixed IDE magic static calls in: $filepath\n";
    }
}
echo "Done replacing magic static forms across models and controllers.\n";
