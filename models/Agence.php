<?php

namespace Models;

use Config\Database;
use PDO;

/**
 * Classe Agence
 * 
 * Gère les opérations CRUD liées aux agences dans la base de données.
 */
class Agence
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
     * Récupère toutes les agences de la base.
     *
     * @return array Liste des agences sous forme de tableau associatif.
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM agences ORDER BY nom ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une agence spécifique par son ID.
     *
     * @param int $id L'identifiant de l'agence.
     * @return array|null Les données de l'agence ou null si introuvable.
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM agences WHERE id_agence = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Crée une nouvelle agence dans la base de données.
     *
     * @param string $nom Le nom de l'agence à ajouter.
     * @return bool Vrai si l'insertion a réussi, faux sinon.
     */
    public function create(string $nom): bool
    {
        $sql = "INSERT INTO agences (nom) VALUES (:nom)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':nom' => $nom]);
    }

    /**
     * Met à jour les informations d'une agence existante.
     *
     * @param int $id L'identifiant de l'agence.
     * @param string $nom Le nouveau nom de l'agence.
     * @return bool Vrai si la mise à jour a réussi, faux sinon.
     */
    public function update(int $id, string $nom): bool
    {
        $sql = "UPDATE agences SET nom = :nom WHERE id_agence = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':nom' => $nom, ':id' => $id]);
    }

    /**
     * Supprime une agence de la base de données.
     *
     * @param int $id L'identifiant de l'agence à supprimer.
     * @return bool Vrai si la suppression a réussi, faux sinon.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM agences WHERE id_agence = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
