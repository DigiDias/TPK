<?php

/** @var \Buki\Router\Router $router */

use Controllers\TrajetController;
use Controllers\ParticipationController;
use Controllers\UserController;
use Controllers\AuthController;
use Controllers\AgenceController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;



$router->get('/test/:id', function ($id) {
    return new Response("Route TEST OK - ID = $id"); // <- OK
});

// Authentification
$router->get('/login', [AuthController::class, 'login']);

// Pour la déconnexion, retourner un RedirectResponse
$router->get('/logout', function () {
    session_destroy();
    return new RedirectResponse('/trajets');
});

// Trajets
$router->post('/login', [AuthController::class, 'login']);

$router->get('/', [TrajetController::class, 'liste']);
$router->get('/trajets', [TrajetController::class, 'liste']);
$router->get('/trajets/creer', [TrajetController::class, 'creer']);
$router->post('/trajets', [TrajetController::class, 'store']);
$router->get('/trajets/modifier/:id', [TrajetController::class, 'modifier']);

$router->post('/trajets/modifier/:id', [TrajetController::class, 'update']);
$router->get('/trajets/supprimer/:id', [TrajetController::class, 'supprimer']);

// Participations
$router->get('/trajets/:id_trajet/participer', function ($id_trajet) {
    $pdo = (new \Config\Database())->getConnection();
    return (new ParticipationController($pdo))->form((int)$id_trajet);
});
$router->post('/participation', function () {
    $pdo = (new \Config\Database())->getConnection();
    return (new ParticipationController($pdo))->store();
});

// Utilisateurs
$router->get('/utilisateurs', [UserController::class, 'AllUsers']);
$router->post('/utilisateurs/update-password', [UserController::class, 'updatePassword']);

// Agences
$router->get('/agences', [AgenceController::class, 'allAgences']);
$router->post('/agences/modifier/:id', [AgenceController::class, 'modifier']);
$router->get('/agences/creer', [AgenceController::class, 'creer']);
$router->post('/agences/creer', [AgenceController::class, 'creer']);
$router->get('/agences/modifier/:id', [AgenceController::class, 'modifier']);
$router->get('/agences/supprimer/:id', [AgenceController::class, 'supprimer']);
