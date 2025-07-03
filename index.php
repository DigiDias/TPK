<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Charge l'autoloader généré par Composer
require_once __DIR__ . '/vendor/autoload.php';

use Config\Database;

$database = new Database();
$pdo = $database->getConnection();

// Charge les routes
require_once __DIR__ . '/routes/web.php';
