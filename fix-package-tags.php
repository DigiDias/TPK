<?php

echo "🔍 Script lancé...\n";

$directories = ['controllers', 'models', 'config'];
$packageName = 'TPK';

foreach ($directories as $dir) {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir)
    );

    foreach ($files as $file) {
        if ($file->isFile() && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            $filePath = $file->getPathname();
            $content = file_get_contents($filePath);

            // Remplace __root__ OU @package vide ou mal formé
            $newContent = preg_replace('/@package\s*(?:__root__)?\s*$/m', "@package $packageName", $content);

            if ($newContent !== $content) {
                file_put_contents($filePath, $newContent);
                echo "✅ Corrigé : $filePath\n";
            } else {
                echo "➖ Rien à corriger dans : $filePath\n";
            }
        }
    }
}

echo "✅ Correction terminée.\n";

