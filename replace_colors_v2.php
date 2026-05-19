<?php
$directory = new RecursiveDirectoryIterator('resources/views');
$iterator = new RecursiveIteratorIterator($directory);
$count = 0;

foreach ($iterator as $info) {
    if ($info->isFile() && $info->getExtension() == 'php') {
        $file = $info->getPathname();
        $content = file_get_contents($file);
        $originalContent = $content;

        // 1. Remplacement des dégradés complexes (ex: dans admin/classes/index.blade.php)
        $content = preg_replace('/bg-gradient-to-[a-z]+ from-[a-z]+-[0-9]+ (via-[a-z]+-[0-9]+ )?to-[a-z]+-[0-9]+/', 'bg-blue-900', $content);
        $content = preg_replace('/bg-gradient-to-[a-z]+ from-[a-z]+-[0-9]+ to-[a-z]+-[0-9]+/', 'bg-blue-900', $content);
        
        // 2. Remplacement de toutes les classes Indigo
        $content = str_replace('bg-indigo-600', 'bg-blue-900', $content);
        $content = str_replace('hover:bg-indigo-700', 'hover:bg-blue-800', $content);
        $content = str_replace('bg-indigo-500', 'bg-blue-800', $content);
        $content = str_replace('text-indigo-600', 'text-blue-900', $content);
        $content = str_replace('border-indigo-500', 'border-blue-900', $content);
        $content = str_replace('bg-indigo-100', 'bg-blue-100', $content);
        $content = str_replace('text-indigo-700', 'text-blue-900', $content);
        $content = str_replace('bg-indigo-50', 'bg-blue-50', $content);
        $content = str_replace('hover:bg-indigo-50', 'hover:bg-blue-50', $content);
        $content = str_replace('text-indigo-100', 'text-blue-100', $content);
        
        // 3. Remplacement de toutes les classes Purple
        $content = str_replace('bg-purple-600', 'bg-blue-900', $content);
        $content = str_replace('hover:bg-purple-700', 'hover:bg-blue-800', $content);
        $content = str_replace('bg-purple-500', 'bg-blue-800', $content);
        $content = str_replace('text-purple-600', 'text-blue-900', $content);
        $content = str_replace('border-purple-500', 'border-blue-900', $content);
        $content = str_replace('bg-purple-100', 'bg-blue-100', $content);
        $content = str_replace('text-purple-700', 'text-blue-900', $content);
        
        // 4. Mettre en JAUNE OR les boutons de création principaux (Nouvelle / Nouveau)
        // On cherche les boutons "Nouvelle Classe", "Nouvel Élève", etc.
        // Exemple de classe bouton blanc d'origine: bg-white text-blue-900 (car indigo remplacé)
        $content = preg_replace(
            '/(class="[^"]*)bg-white([^"]*text-blue-900[^"]*")([^>]*>\s*<svg[^>]*>.*?<\/svg>\s*(Nouvelle|Nouveau|Créer|Ajouter))/is', 
            '$1bg-yellow-500$2$3', 
            $content
        );

        $content = preg_replace(
            '/(class="[^"]*)bg-blue-900([^"]*text-white[^"]*")([^>]*>\s*<svg[^>]*>.*?<\/svg>\s*(Nouvelle|Nouveau|Créer|Ajouter))/is', 
            '$1bg-yellow-500 text-blue-900 font-bold$2$3', 
            $content
        );
        
        // Remplacer les boutons "bg-yellow-500 text-white" par "text-blue-900" pour plus de contraste
        $content = str_replace('bg-yellow-500 text-white', 'bg-yellow-500 text-blue-900 font-bold', $content);

        // 5. Mettre l'icône de l'en-tête (souvent le premier bg-blue-900 p-2/p-3 avec text-white) en jaune
        $content = preg_replace('/(bg-blue-900[^>]+>\s*<svg[^>]+class="[^"]*)text-white/', '$1text-yellow-500', $content);

        if ($content !== $originalContent) {
            file_put_contents($file, $content);
            $count++;
            echo "Updated: $file\n";
        }
    }
}
echo "Total files updated: $count\n";
