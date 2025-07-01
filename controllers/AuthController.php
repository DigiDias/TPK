<?php

require_once __DIR__ . '/../models/Auth.php';

/**
 * Contrôleur gérant les opérations d'authentification.
 */
class AuthController
{
    /**
     * Gère la connexion de l'utilisateur.
     * Si la méthode est POST, vérifie les identifiants et démarre la session.
     * Sinon, affiche le formulaire de connexion.
     *
     * @return void
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $auth = new Auth();
            $user = $auth->verifyCredentials($email, $password);

            if ($user) {
                session_start();
                $_SESSION['user'] = $user;

                // Redirection après connexion réussie
                header("Location: index.php?action=listTrajets");
                exit;
            } else {
                // Connexion échouée : email ou mot de passe incorrect
                $error = "Email ou mot de passe incorrect.";
                require __DIR__ . '/../views/Auth/Auth.php';
            }
        } else {
            // Affichage du formulaire de connexion
            $error = "";
            require __DIR__ . '/../views/Auth/Auth.php';
        }
    }
}
