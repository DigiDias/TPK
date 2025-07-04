<?php

namespace Controllers;

use Models\User;

/**
 * Contrôleur gérant les opérations liées aux utilisateurs.
 */
class UserController
{
    /**
     * Met à jour le mot de passe d'un utilisateur via une requête POST (JSON).
     *
     * Cette méthode lit un corps JSON contenant les champs `email` et `password`,
     * vérifie leur présence, et appelle la méthode du modèle User pour
     * enregistrer le mot de passe (après hashage côté modèle).
     *
     * Réponses HTTP possibles :
     * - 200 : Succès
     * - 400 : Email ou mot de passe manquant
     * - 404 : Utilisateur introuvable
     * - 405 : Méthode HTTP non autorisée
     *
     * @return void
     */
    public function updatePassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $email = $data['email'] ?? null;
            $password = $data['password'] ?? null;

            if (!$email || !$password) {
                http_response_code(400);
                echo json_encode(["error" => "Email et mot de passe requis."]);
                return;
            }

            $userModel = new User();
            $success = $userModel->setPasswordByEmail($email, $password);

            if ($success) {
                echo json_encode(["message" => "Mot de passe mis à jour avec succès."]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Utilisateur non trouvé."]);
            }
        } else {
            http_response_code(405);
            echo json_encode(["error" => "Méthode non autorisée."]);
        }
    }

    /**
     * Affiche la liste de tous les utilisateurs.
     *
     * Cette méthode est accessible uniquement via une requête GET.
     * Les données sont récupérées depuis le modèle User et envoyées à la vue `list-users.php`.
     *
     * @return void
     */
    public function AllUsers(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $userModel = new User();
            $users = $userModel->getAllUser();

            // Chargement de la vue avec les données utilisateurs
            require __DIR__ . '/../views/users/List-users.php';
        } else {
            // Requête non autorisée
            http_response_code(405);
            echo "Méthode non autorisée.";
        }
    }
}
