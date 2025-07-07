<?php

namespace Controllers;

use Models\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @return JsonResponse
     */
    public function updatePassword(): JsonResponse
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return new JsonResponse(['error' => 'Méthode non autorisée.'], 405);
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return new JsonResponse(['error' => 'Email et mot de passe requis.'], 400);
        }

        $userModel = new User();
        $success = $userModel->setPasswordByEmail($email, $password);

        if ($success) {
            return new JsonResponse(['message' => 'Mot de passe mis à jour avec succès.']);
        }

        return new JsonResponse(['error' => 'Utilisateur non trouvé.'], 404);
    }

    /**
     * Affiche la liste de tous les utilisateurs.
     *
     * Cette méthode est accessible uniquement via une requête GET.
     * Les données sont récupérées depuis le modèle User et envoyées à la vue `list-users.php`.
     *
     * @return Response
     */
    public function AllUsers(): Response
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return new Response("Méthode non autorisée.", 405);
        }

        $userModel = new User();
        $users = $userModel->getAllUser();

        ob_start();
        require __DIR__ . '/../views/users/List-users.php';
        $content = ob_get_clean();

        return new Response($content);
    }
}
