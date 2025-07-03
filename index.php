<?php

/**
 * Point d’entrée principal de l’application.
 * 
 * Ce fichier initialise la session, configure l'autoloader, établit la connexion
 * à la base de données et charge les routes de l'application.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Chargement de l'autoloader généré par Composer
require_once __DIR__ . '/vendor/autoload.php';

use Config\Database;

// Initialisation de la connexion à la base de données
$database = new Database();
$pdo = $database->getConnection();

// Inclusion des routes de l'application
require_once __DIR__ . '/routes/web.php';
