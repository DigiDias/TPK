<?php
/**
 * Routeur principal
 * Initialise la session, charge la connexion à la BDD et redirige selon l’action
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connexion DB
require_once 'config/database.php';
$database = new Database();
$pdo = $database->getConnection();

// Contrôleurs
require_once 'controllers/TrajetController.php';
require_once 'controllers/ParticipationController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/AuthController.php';

// Action demandée
$action = $_GET['action'] ?? 'listTrajets';

// Route
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

case 'creer':
        $controller = new TrajetController();
        $controller->creer();
        break;

    case 'modifier':
        if (isset($_GET['id_trajet'])) {
            $controller = new TrajetController();
            $controller->modifier((int)$_GET['id_trajet']);
        } else {
            echo "ID de trajet manquant.";
        }
        break;

    case 'updateTrajet':
        if (isset($_GET['id_trajet'])) {
            $controller = new TrajetController();
            $controller->update((int)$_GET['id_trajet']);
        } else {
            echo "ID de trajet manquant.";
        }
        break;

    case 'participer':
        if (isset($_GET['id_trajet'])) {
            $controller = new ParticipationController($pdo);
            $controller->form($_GET['id_trajet']);
        } else {
            echo "ID de trajet manquant.";
        }
        break;

case 'store-trajet':
    $controller = new TrajetController();
    $controller->store();
    break;

        
  

    case 'update_password':
        $controller = new UserController();
        $controller->updatePassword();
        break;

    default:
        echo "Action inconnue.";
        break;
}
