<?php

use Controllers\TrajetController;
use Controllers\ParticipationController;
use Controllers\UserController;
use Controllers\AuthController;

// Action demandée
$action = $_GET['action'] ?? 'listTrajets';

switch ($action) {
    case 'login':
        (new AuthController())->login();
        break;

    case 'logout':
        session_destroy();
        header('Location: index.php?action=listTrajets');
        exit;

    case 'listTrajets':
        (new TrajetController())->liste();
        break;

    case 'creer':
        (new TrajetController())->creer();
        break;

    case 'store-trajet':
        (new TrajetController())->store();
        break;

    case 'modifier':
        if (isset($_GET['id_trajet'])) {
            (new TrajetController())->modifier((int)$_GET['id_trajet']);
        } else {
            echo "ID de trajet manquant.";
        }
        break;

    case 'updateTrajet':
        if (isset($_GET['id_trajet'])) {
            (new TrajetController())->update((int)$_GET['id_trajet']);
        } else {
            echo "ID de trajet manquant.";
        }
        break;

    case 'participer':
        if (isset($_GET['id_trajet'])) {
            (new ParticipationController($pdo))->form((int)$_GET['id_trajet']);
        } else {
            echo "ID de trajet manquant.";
        }
        break;

    case 'store-participation':
        (new ParticipationController($pdo))->store();
        break;

    case 'update_password':
        (new UserController())->updatePassword();
        break;

        case 'supprimer':
    (new TrajetController())->supprimer($_GET['id_trajet']);
    break;

    default:
        echo "Action inconnue.";
        break;
}
