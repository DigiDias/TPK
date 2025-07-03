<?php

namespace Controllers;

use Models\Agence;

class AgenceController
{
    public function allAgences(): void
    {
        $agenceModel = new Agence();
        $agences = $agenceModel->getAll();
        require __DIR__ . '/../views/agences/agences.php';
    }

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

    public function supprimer(int $id): void
    {
        $agenceModel = new Agence();
        $agenceModel->delete($id);
        header("Location: index.php?action=List-agences");
        exit;
    }
}
