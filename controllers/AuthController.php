<?php

namespace Controllers;

use Models\Auth;

/**
 * Contrôleur gérant les opérations d'authentification.
 */
class AuthController
{
    /**
     * Gère la connexion de l'utilisateur.
     *
     * - Si la méthode est POST :
     *   - Récupère les identifiants.
     *   - Vérifie leur validité via le modèle `Auth`.
     *   - Si valides, initialise la session et stocke les infos utilisateur.
     *   - Redirige vers la page des trajets.
     * - Sinon :
     *   - Affiche le formulaire de connexion.
     *
     * @return void
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $auth = new Auth();
            $user = $auth->verifyCredentials($email, $password);

            if ($user && isset($user['id_user'])) {
                // Démarrage de la session si non encore démarrée
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                // Enregistrement des infos utilisateur dans la session
                $_SESSION['user'] = [
                    'id'     => $user['id_user'],
                    'prenom' => $user['prenom'],
                    'nom'    => $user['nom'],
                    'email'  => $user['email'],
                    'role'   => $user['role'] ?? 'user'
                ];

                // Redirection après connexion réussie
                header("Location: index.php?action=listTrajets");
                exit;
            } else {
                // Échec de connexion
                $error = "Email ou mot de passe incorrect.";
                require __DIR__ . '/../views/Auth/Auth.php';
            }
        } else {
            // Affichage du formulaire
            $error = "";
            require __DIR__ . '/../views/Auth/Auth.php';
        }
    }
}
