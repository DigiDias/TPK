<?php

namespace Models;

use Config\Database;
use PDO;

/**
 * Classe User
 *
 * Gère les opérations liées aux utilisateurs dans la base de données.
 */
class User
{
    /**
     * Instance PDO pour la connexion à la base de données.
     *
     * @var PDO
     */
    private PDO $db;

    /**
     * Constructeur
     *
     * Initialise la connexion à la base de données via la classe Database.
     */
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Met à jour le mot de passe d’un utilisateur à partir de son adresse email.
     *
     * @param string $email L’adresse email de l’utilisateur.
     * @param string $password Le nouveau mot de passe (non hashé).
     * @return bool Vrai si la mise à jour a réussi, faux sinon.
     */
    public function setPasswordByEmail(string $email, string $password): bool
    {
        $sql = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    /**
     * Récupère tous les utilisateurs de la base de données.
     *
     * @return array Liste des utilisateurs sous forme de tableau associatif.
     */
    public function getAllUser(): array
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
