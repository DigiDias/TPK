<?php
session_start();
require_once 'controllers/TrajetController.php';
require_once 'controllers/ParticipationController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/AuthController.php';

$action = $_GET['action'] ?? 'listTrajets';

switch ($action) {
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
case 'logout':
    session_destroy();
    header('Location: index.php?action=login');
    exit;

    case 'listTrajets':
        $controller = new TrajetController();
        $controller->liste();
        break;

    case 'participer':
        $controller = new ParticipationController();
        $controller->form($_GET['id_trajet']);
        break;

    case 'storeParticipation':
        $controller = new ParticipationController();
        $controller->store();
        break;

    case 'update_password': // ✅ Nouvelle route
        $controller = new UserController();
        $controller->updatePassword();
        break;

    default:
        echo "Action inconnue.";
}
