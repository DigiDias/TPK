<?php

namespace Controllers;

use Models\Agence;

/**
 * Contrôleur gérant les opérations liées aux agences.
 */
class AgenceController
{
    /**
     * Affiche la liste de toutes les agences.
     *
     * @return void
     */
    public function allAgences(): void
    {
        $agenceModel = new Agence();
        $agences = $agenceModel->getAll();
        require __DIR__ . '/../views/agences/agences.php';
    }

    /**
     * Crée une nouvelle agence.
     *
     * - Si la requête est en POST, tente de créer l’agence avec les données soumises.
     * - Sinon, affiche le formulaire de création.
     *
     * @return void
     */
    public function creer(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');

            if ($nom) {
                $agenceModel = new Agence();
                $agenceModel->create($nom);
                header("Location: index.php?action=List-agences");
                exit;
            } else {
                $_SESSION['error'] = "Le nom est requis.";
            }
        }

        require __DIR__ . '/../views/agences/form-agence.php';
    }

    /**
     * Modifie une agence existante.
     *
     * - Affiche le formulaire avec les données de l’agence.
     * - Si la requête est en POST, met à jour l’agence.
     *
     * @param int $id L'identifiant de l'agence à modifier
     * @return void
     */
    public function modifier(int $id): void
    {
        $agenceModel = new Agence();
        $agence = $agenceModel->getById($id);

        if (!$agence) {
            echo "Agence introuvable.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');

            if ($nom) {
                $agenceModel->update($id, $nom);
                header("Location: index.php?action=List-agences");
                exit;
            } else {
                $_SESSION['error'] = "Le nom est requis.";
            }
        }

        require __DIR__ . '/../views/agences/form-agence.php';
    }

    /**
     * Supprime une agence.
     *
     * @param int $id L'identifiant de l'agence à supprimer
     * @return void
     */
    public function supprimer(int $id): void
    {
        $agenceModel = new Agence();
        $agenceModel->delete($id);
        header("Location: index.php?action=List-agences");
        exit;
    }
}
