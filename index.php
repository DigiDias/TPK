<?php
// index.php

// En haut de ton index.php
error_reporting(E_ALL & ~E_DEPRECATED);


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoloader Composer
require_once __DIR__ . '/vendor/autoload.php';

use Config\Database;
use Buki\Router\Router;

// Connexion à la base de données
$database = new Database();
$pdo = $database->getConnection();

// Configuration du routeur
$router = new Router([
    'paths' => [
        'controllers' => 'controllers',
    ],
    'namespaces' => [
        'controllers' => 'Controllers',
    ],
  

      
]);


// Routes
require_once __DIR__ . '/routes/web.php';


// Lancement du routeur
$router->run();
