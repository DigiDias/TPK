<?php
require_once 'controllers/TrajetController.php';
require_once 'controllers/ParticipationController.php';

$action = $_GET['action'] ?? 'listTrajets';

switch ($action) {
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

    default:
        echo "Action inconnue.";
}
