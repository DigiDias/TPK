<?php

namespace Models;

use Config\Database;
use PDO;

class Agence
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Retourne toutes les agences
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM agences ORDER BY nom ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une agence par son ID
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM agences WHERE id_agence = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Crée une nouvelle agence
     */
    public function create(string $nom): bool
    {
        $sql = "INSERT INTO agences (nom) VALUES (:nom)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':nom' => $nom]);
    }

    /**
     * Met à jour une agence
     */
    public function update(int $id, string $nom): bool
    {
        $sql = "UPDATE agences SET nom = :nom WHERE id_agence = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':nom' => $nom, ':id' => $id]);
    }

    /**
     * Supprime une agence
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM agences WHERE id_agence = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
