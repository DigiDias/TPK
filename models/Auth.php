<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Classe Auth
 * Gère l'authentification des utilisateurs.
 */
class Auth {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Vérifie les identifiants de l'utilisateur.
     *
     * @param string $email
     * @param string $password
     * @return array|false Les données utilisateur si valides, sinon false.
     */
    public function verifyCredentials($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
