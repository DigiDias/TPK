<?php

namespace Controllers;

use Models\Agence;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contrôleur gérant les opérations liées aux agences.
 */
class AgenceController
{
    /**
     * Affiche la liste de toutes les agences.
     *
     * @return Response
     */
    public function allAgences(): Response
    {
        $agenceModel = new Agence();
        $agences = $agenceModel->getAll();

        ob_start();
        require __DIR__ . '/../views/agences/agences.php';
        $content = ob_get_clean();

        return new Response($content);
    }

    /**
     * Crée une nouvelle agence ou affiche le formulaire.
     *
     * - Si la requête est POST, tente de créer l’agence.
     * - Sinon, affiche le formulaire.
     *
     * @return Response
     */
    public function creer(): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');

            if ($nom) {
                $agenceModel = new Agence();
                $agenceModel->create($nom);
                header("Location: /agences"); // Redirection HTTP classique
                exit;
            }

            $_SESSION['error'] = "Le nom est requis.";
        }

        ob_start();
        require __DIR__ . '/../views/agences/form-agence.php';
        $content = ob_get_clean();

        return new Response($content);
    }

    /**
     * Modifie une agence existante.
     *
     * - Affiche le formulaire avec les données actuelles.
     * - Si la requête est POST, effectue la mise à jour.
     *
     * @param int $id L'identifiant de l'agence à modifier
     * @return Response
     */
    public function modifier(int $id): Response
    {
        $agenceModel = new Agence();
        $agence = $agenceModel->getById($id);

        if (!$agence) {
            return new Response("Agence introuvable", 404);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');

            if ($nom) {
                $agenceModel->update($id, $nom);
                header("Location: /agences");
                exit;
            }

            $_SESSION['error'] = "Le nom est requis.";
        }

        ob_start();
        require __DIR__ . '/../views/agences/form-agence.php';
        $content = ob_get_clean();

        return new Response($content);
    }

    /**
     * Supprime une agence.
     *
     * @param int $id L'identifiant de l'agence à supprimer
     * @return Response
     */
    public function supprimer(int $id): Response
    {
        $agenceModel = new Agence();
        $agenceModel->delete($id);

        header("Location: /agences");
        exit;
    }
}
