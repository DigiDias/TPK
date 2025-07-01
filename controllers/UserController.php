<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    public function updatePassword() {
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
}
