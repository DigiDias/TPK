<?php
// router.php


// Si la requête correspond à un fichier physique (ex: CSS, JS, images), on le sert tel quel
if (php_sapi_name() === 'cli-server') {
    $url  = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $file = __DIR__ . $url;

    if (is_file($file)) {
        return false;
    }
}

// Sinon, on passe tout par index.php
require_once __DIR__ . '/index.php';






