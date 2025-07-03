<?php

require_once __DIR__ . '/../config/database.php';

/**
 * Classe Agence
 * 
 * Gère les interactions avec la table `agences`.
 */
class Agence
{
    /**
     * Instance PDO
     * 
     * @var PDO
     */
    private PDO $db;

    /**
     * Constructeur : initialise la connexion à la base de données
     */
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Récupère toutes les agences
     * 
     * @return array Liste des agences
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM agences ORDER BY nom ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une agence par son ID
     *
     * @param int $id Identifiant de l'agence
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM agences WHERE id_agence = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $agence = $stmt->fetch(PDO::FETCH_ASSOC);
        return $agence ?: null;
    }
}
