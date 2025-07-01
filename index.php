<?php
/**
 * Routeur principal
 * Initialise la session, charge la connexion à la BDD et redirige selon l’action
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/database.php';
$database = new Database();
$pdo = $database->getConnection();

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
        if (isset($_GET['id_trajet'])) {
            $controller = new ParticipationController($pdo);
            $controller->form($_GET['id_trajet']);
        } else {
            echo "ID de trajet manquant.";
        }
        break;

    case 'store-participation':
        $controller = new ParticipationController($pdo);
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
