<?php
$directory = new RecursiveDirectoryIterator('resources/views');
$iterator = new RecursiveIteratorIterator($directory);
$count = 0;

foreach ($iterator as $info) {
    if ($info->isFile() && $info->getExtension() == 'php') {
        $file = $info->getPathname();
        $content = file_get_contents($file);
        $originalContent = $content;

        // 1. Enlever les fonds de page colorés arc-en-ciel
        $content = str_replace('bg-gradient-to-br from-blue-50 via-white to-purple-50', 'bg-transparent', $content);
        
        // 2. Remplacer les boutons/headers en Bleu Marine profond
        $content = preg_replace('/bg-gradient-to-[a-z]+ from-blue-[0-9]+ to-purple-[0-9]+/', 'bg-blue-900', $content);
        
        // 3. Fallbacks pour les classes restantes
        $content = str_replace('from-blue-600 to-purple-600', 'bg-blue-900', $content);
        $content = str_replace('from-blue-500 to-purple-500', 'bg-blue-800', $content);
        
        // 4. Mettre à jour les effets hover des anciens boutons arc-en-ciel
        $content = preg_replace('/hover:from-blue-[0-9]+ hover:to-purple-[0-9]+/', 'hover:bg-blue-800', $content);

        // 5. Remplacer text-purple-600 par text-blue-900 dans les liens/titres si pertinent
        $content = str_replace('text-purple-600', 'text-yellow-600', $content);
        $content = str_replace('text-blue-600 hover:text-purple-600', 'text-blue-900 hover:text-yellow-600', $content);
        $content = str_replace('text-blue-600', 'text-blue-900', $content);

        if ($content !== $originalContent) {
            file_put_contents($file, $content);
            $count++;
            echo "Updated: $file\n";
        }
    }
}
echo "Total files updated: $count\n";
