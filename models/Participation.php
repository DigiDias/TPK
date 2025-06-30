<?php

require_once __DIR__ . '/../config/database.php';

/**
 * Classe Participation
 * 
 * Gère les interactions avec la table `participations`.
 */
class Participation {

    /**
     * @var PDO Connexion à la base de données
     */
    private $db;

    /**
     * Constructeur : établit la connexion à la base de données.
     */
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Ajoute une participation à un trajet pour un utilisateur.
     *
     * @param int $id_user L'identifiant de l'utilisateur
     * @param int $id_trajet L'identifiant du trajet
     * @return bool True si l'insertion a réussi, false sinon
     */
    public function ajouterParticipation($id_user, $id_trajet) {
        $sql = "INSERT INTO participations (id_user, id_trajet, date_inscription)
                VALUES (:id_user, :id_trajet, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':id_trajet', $id_trajet, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Récupère toutes les participations.
     *
     * @return array Liste des participations
     */
    public function getAll() {
        $sql = "SELECT * FROM participations";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
