<?php

namespace Controllers;

use Models\Trajet;
use Models\Agence;

/**
 * Contrôleur chargé de gérer les trajets (liste, création, modification, suppression).
 */
class TrajetController
{
    /**
     * Affiche la liste de tous les trajets à venir.
     *
     * @return void
     */
    public function liste(): void
    {
        $trajetModel = new Trajet();
        $trajets = $trajetModel->getAll();
        require __DIR__ . '/../views/trajets/liste.php';
    }

    /**
     * Affiche le formulaire de création d'un nouveau trajet.
     *
     * @return void
     */
    public function creer(): void
    {
        $agenceModel = new Agence();
        $agences = $agenceModel->getAll();
        require __DIR__ . '/../views/trajets/creer-trajet.php';
    }

    /**
     * Affiche le formulaire de modification d’un trajet.
     *
     * @param int $id_trajet ID du trajet à modifier
     * @return void
     */
    public function modifier(int $id_trajet): void
    {
        $trajetModel = new Trajet();
        $agenceModel = new Agence();

        $trajet = $trajetModel->getById($id_trajet);
        $agences = $agenceModel->getAll();

        if (!$trajet || $_SESSION['user']['id'] != $trajet['id_createur']) {
            die('Accès non autorisé.');
        }

        require __DIR__ . '/../views/trajets/modification-trajet.php';
    }

    /**
     * Met à jour les données d’un trajet après modification.
     *
     * @param int $id_trajet ID du trajet à mettre à jour
     * @return void
     */
    public function update(int $id_trajet): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $depart         = $_POST['agence_depart_id'];
        $arrivee        = $_POST['agence_arrivee_id'];
        $dateDepart     = $_POST['date_depart'];
        $heureDepart    = $_POST['heure_depart'];
        $dateArrivee    = $_POST['date_arrivee'];
        $heureArrivee   = $_POST['heure_arrivee'];
        $today          = date('Y-m-d');

        // Règles métier
        if ($depart === $arrivee) {
            $_SESSION['error'] = "L'agence de départ ne peut pas être la même que l'agence d'arrivée.";
        } elseif ($dateDepart < $today) {
            $_SESSION['error'] = "La date de départ ne peut pas être antérieure à aujourd'hui.";
        } elseif ($dateDepart > $dateArrivee) {
            $_SESSION['error'] = "La date de départ ne peut pas être supérieure à la date d'arrivée.";
        } elseif ($dateDepart === $dateArrivee && $heureArrivee <= $heureDepart) {
            $_SESSION['error'] = "L'heure d'arrivée doit être supérieure à l'heure de départ si les dates sont identiques.";
        }

        if (!empty($_SESSION['error'])) {
            header("Location: index.php?action=modifier&id_trajet=" . $id_trajet);
            exit;
        }

        $trajetModel = new Trajet();
        $trajetModel->updateTrajet($id_trajet, $_POST);

        $_SESSION['success'] = "Le trajet a été modifié.";
        header('Location: index.php?action=listTrajets');
        exit;
    }

    /**
     * Enregistre un nouveau trajet dans la base de données.
     *
     * @return void
     */
    public function store(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $depart      = $_POST['agence_depart_id'];
        $arrivee     = $_POST['agence_arrivee_id'];
        $dateDepart  = $_POST['date_depart'];
        $heureDepart = $_POST['heure_depart'];
        $dateArrivee = $_POST['date_arrivee'];
        $heureArrivee= $_POST['heure_arrivee'];
        $places      = $_POST['places_dispo'];
        $today       = date('Y-m-d');

        // Règles métier
        if ($depart === $arrivee) {
            $_SESSION['error'] = "L'agence de départ ne peut pas être la même que l'agence d'arrivée.";
        } elseif ($dateDepart < $today) {
            $_SESSION['error'] = "La date de départ ne peut pas être antérieure à aujourd'hui.";
        } elseif ($dateDepart > $dateArrivee) {
            $_SESSION['error'] = "La date de départ ne peut pas être supérieure à la date d'arrivée.";
        } elseif ($dateDepart === $dateArrivee && $heureArrivee <= $heureDepart) {
            $_SESSION['error'] = "L'heure d'arrivée doit être supérieure à l'heure de départ si les dates sont identiques.";
        }

        if (!empty($_SESSION['error'])) {
            header("Location: index.php?action=creer");
            exit;
        }

        $trajetModel = new Trajet();
        $trajetModel->creerTrajet([
            'id_createur'       => $_SESSION['user']['id'],
            'agence_depart_id'  => $depart,
            'agence_arrivee_id' => $arrivee,
            'date_depart'       => $dateDepart,
            'date_arrivee'      => $dateArrivee,
            'heure_depart'      => $heureDepart,
            'heure_arrivee'     => $heureArrivee,
            'places_dispo'      => $places,
            'contact_tel'       => $_SESSION['user']['tel'] ?? '',
            'contact_email'     => $_SESSION['user']['email']
        ]);

        $_SESSION['success'] = "Trajet créé avec succès.";
        header("Location: index.php?action=listTrajets");
        exit;
    }

    /**
     * Supprime un trajet par son ID s'il appartient au créateur.
     *
     * @param int $id_trajet ID du trajet à supprimer
     * @return void
     */
public function supprimer(int $id_trajet): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $trajetModel = new Trajet();
    $trajet = $trajetModel->getById($id_trajet);

    // Vérifie si le trajet existe et si l'utilisateur est soit le créateur, soit un admin
    if (
        !$trajet ||
        (
            $_SESSION['user']['id'] != $trajet['id_createur'] &&
            $_SESSION['user']['role'] !== 'admin'
        )
    ) {
        $_SESSION['error'] = "Suppression non autorisée.";
        header("Location: index.php?action=listTrajets");
        exit;
    }

    $trajetModel->delete($id_trajet);
    $_SESSION['success'] = "Trajet supprimé avec succès.";
    header("Location: index.php?action=listTrajets");
    exit;
}
}
