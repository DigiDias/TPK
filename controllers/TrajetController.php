<?php

namespace Controllers;

use Models\Trajet;
use Models\Agence;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Contrôleur chargé de gérer les trajets (liste, création, modification, suppression).
 */
class TrajetController
{
    /**
     * Affiche la liste de tous les trajets.
     *
     * @return Response
     */
    public function liste(): Response
    {
        $trajetModel = new Trajet();
        $trajets = $trajetModel->getAll();

        ob_start();
        require __DIR__ . '/../views/trajets/liste.php';
        $content = ob_get_clean();

        return new Response($content);
    }

    /**
     * Affiche le formulaire de création d’un trajet.
     *
     * @return Response
     */
    public function creer(): Response
    {
        $agenceModel = new Agence();
        $agences = $agenceModel->getAll();

        ob_start();
        require __DIR__ . '/../views/trajets/creer-trajet.php';
        $content = ob_get_clean();

        return new Response($content);
    }

    /**
     * Affiche le formulaire de modification d’un trajet.
     *
     * @param int $id_trajet ID du trajet à modifier
     * @return Response
     */
    public function modifier(int $id_trajet): Response
    {
        
        if (session_status() === PHP_SESSION_NONE) session_start();

        $trajetModel = new Trajet();
        $agenceModel = new Agence();

        $trajet = $trajetModel->getById($id_trajet);
        $agences = $agenceModel->getAll();

        if (!$trajet || $_SESSION['user']['id'] != $trajet['id_createur']) {
            return new Response('Accès non autorisé.', 403);
        }

            

    if (!$trajet || $_SESSION['user']['id'] != $trajet['id_createur']) {
        return new Response('Accès non autorisé.', 403);
    }


        ob_start();
        require __DIR__ . '/../views/trajets/modification-trajet.php';
        $content = ob_get_clean();

        return new Response($content);
    }

    /**
     * Met à jour les informations d’un trajet après soumission du formulaire.
     *
     * @param int $id_trajet ID du trajet à mettre à jour
     * @return RedirectResponse
     */
    public function update(int $id_trajet): RedirectResponse
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $depart       = $_POST['agence_depart_id'];
        $arrivee      = $_POST['agence_arrivee_id'];
        $dateDepart   = $_POST['date_depart'];
        $heureDepart  = $_POST['heure_depart'];
        $dateArrivee  = $_POST['date_arrivee'];
        $heureArrivee = $_POST['heure_arrivee'];
        $today        = date('Y-m-d');

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
            return new RedirectResponse("/trajets/modifier/$id_trajet");
        }

        $trajetModel = new Trajet();
        $trajetModel->updateTrajet($id_trajet, $_POST);

        $_SESSION['success'] = "Le trajet a été modifié.";
        return new RedirectResponse("/trajets");
    }

    /**
     * Enregistre un nouveau trajet après validation.
     *
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $depart       = $_POST['agence_depart_id'];
        $arrivee      = $_POST['agence_arrivee_id'];
        $dateDepart   = $_POST['date_depart'];
        $heureDepart  = $_POST['heure_depart'];
        $dateArrivee  = $_POST['date_arrivee'];
        $heureArrivee = $_POST['heure_arrivee'];
        $places       = $_POST['places_dispo'];
        $today        = date('Y-m-d');

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
            return new RedirectResponse("/trajets/creer");
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
        return new RedirectResponse("/trajets");
    }

    /**
     * Supprime un trajet si l'utilisateur est le créateur ou un admin.
     *
     * @param int $id_trajet
     * @return RedirectResponse
     */
    public function supprimer(int $id_trajet): RedirectResponse
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $trajetModel = new Trajet();
        $trajet = $trajetModel->getById($id_trajet);

        if (
            !$trajet ||
            ($_SESSION['user']['id'] != $trajet['id_createur'] && $_SESSION['user']['role'] !== 'admin')
        ) {
            $_SESSION['error'] = "Suppression non autorisée.";
            return new RedirectResponse("/trajets");
        }

        $trajetModel->delete($id_trajet);
        $_SESSION['success'] = "Trajet supprimé avec succès.";
        return new RedirectResponse("/trajets");
    }
}
