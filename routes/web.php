<?php

// Import des contrôleurs
use Controllers\TrajetController;
use Controllers\ParticipationController;
use Controllers\UserController;
use Controllers\AuthController;
use Controllers\AgenceController; // ✅ Important pour éviter l'erreur "Class not found"

// Détermination de l'action demandée
$action = $_GET['action'] ?? 'listTrajets';

// Routeur principal
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

    case 'ListUsers':
        (new UserController())->AllUsers();
        break;

    case 'List-agences': // ✅ Le nom est OK si tu accèdes avec ?action=List-agences
        (new AgenceController())->allAgences();
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
        if (isset($_GET['id_trajet'])) {
            (new TrajetController())->supprimer((int)$_GET['id_trajet']);
        } else {
            echo "ID de trajet manquant.";
        }
        break;

     case 'creerAgence':
    (new AgenceController())->creer();
    break;

case 'modifierAgence':
    (new AgenceController())->modifier((int)$_GET['id_agence']);
    break;

case 'supprimerAgence':
    (new AgenceController())->supprimer((int)$_GET['id_agence']);
    break;   

    default:
        echo "Action inconnue.";
        break;
}
