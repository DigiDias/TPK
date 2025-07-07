<?php

namespace Controllers;

use Models\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Contrôleur gérant les opérations d'authentification.
 */
class AuthController
{
    /**
     * Gère l'affichage du formulaire de connexion et la vérification des identifiants.
     *
     * - Si la méthode est POST :
     *   - Récupère les identifiants.
     *   - Vérifie leur validité via le modèle `Auth`.
     *   - Si valides, initialise la session et redirige vers les trajets.
     *   - Sinon, affiche un message d'erreur.
     * - Si GET : affiche le formulaire de connexion.
     *
     * @return Response|RedirectResponse
     */
    public function login(): Response|RedirectResponse
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $auth = new Auth();
            $user = $auth->verifyCredentials($email, $password);

            if ($user && isset($user['id_user'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['user'] = [
                    'id'     => $user['id_user'],
                    'prenom' => $user['prenom'],
                    'nom'    => $user['nom'],
                    'email'  => $user['email'],
                    'tel'    => $user['tel'] ?? '',
                    'role'   => $user['role'] ?? 'user'
                ];

                return new RedirectResponse('/trajets');
            } else {
                // Erreur de connexion
                $error = "Email ou mot de passe incorrect.";

                ob_start();
                require __DIR__ . '/../views/Auth/Auth.php';
                $content = ob_get_clean();

                return new Response($content);
            }
        } else {
            // Affichage du formulaire de login
            $error = "";

            ob_start();
            require __DIR__ . '/../views/Auth/Auth.php';
            $content = ob_get_clean();

            return new Response($content);
        }
    }
}
