<?php

/**
 * Routeur principal de l'application.
 *
 * Ce fichier analyse le paramètre `action` passé via l'URL
 * et délègue la logique correspondante au bon contrôleur.
 */

// Import des contrôleurs
use Controllers\TrajetController;
use Controllers\ParticipationController;
use Controllers\UserController;
use Controllers\AuthController;
use Controllers\AgenceController; // Gestion des agences
use Config\Database; // Pour initialiser PDO si besoin

// Détermination de l'action demandée via l'URL (GET)
$action = $_GET['action'] ?? 'listTrajets';

// Logique de routage
switch ($action) {

    // Authentification
    case 'login':
        (new AuthController())->login();
        break;

    case 'logout':
        session_destroy();
        header('Location: index.php?action=listTrajets');
        exit;

    // Trajets
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

    case 'supprimer':
        if (isset($_GET['id_trajet'])) {
            (new TrajetController())->supprimer((int)$_GET['id_trajet']);
        } else {
            echo "ID de trajet manquant.";
        }
        break;

    // Utilisateurs
    case 'ListUsers':
        (new UserController())->AllUsers();
        break;

    case 'update_password':
        (new UserController())->updatePassword();
        break;

    // Participations
    case 'participer':
        if (isset($_GET['id_trajet'])) {
            $pdo = (new Database())->getConnection();
            (new ParticipationController($pdo))->form((int)$_GET['id_trajet']);
        } else {
            echo "ID de trajet manquant.";
        }
        break;

    case 'store-participation':
        $pdo = (new Database())->getConnection();
        (new ParticipationController($pdo))->store();
        break;

    // Agences
    case 'List-agences':
        (new AgenceController())->allAgences();
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

    // Action inconnue
    default:
        echo "Action inconnue.";
        break;
}
