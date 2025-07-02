<?php

require_once __DIR__ . '/../config/database.php';

/**
 * Classe Auth
 * Gère l'authentification des utilisateurs.
 */
class Auth
{
    /**
     * @var PDO Connexion à la base de données
     */
    private PDO $db;

    /**
     * Constructeur : initialise la connexion à la base de données.
     */
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Vérifie les identifiants de l'utilisateur.
     *
     * @param string $email Email de l'utilisateur
     * @param string $password Mot de passe en clair
     * @return array|false Retourne les données de l'utilisateur si OK, sinon false
     */
    public function verifyCredentials(string $email, string $password): array|false
    {
        $sql = "SELECT id_user, prenom, nom, email, password, role FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifie que le mot de passe correspond
        if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
