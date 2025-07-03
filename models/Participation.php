<?php

namespace Models;
use Config\Database;
use PDO;

/**
 * Modèle Participation
 * Gère les interactions avec la table `participations`
 */
class Participation {

    /**
     * @var PDO Connexion PDO à la base
     */
    private PDO $db;

    /**
     * Constructeur avec injection PDO
     *
     * @param PDO $pdo Connexion à la base de données
     */
    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    /**
     * Enregistre une nouvelle participation
     *
     * @param int $id_user Identifiant de l'utilisateur
     * @param int $id_trajet Identifiant du trajet
     * @return bool True si succès, false sinon
     */
    public function ajouterParticipation(int $id_user, int $id_trajet): bool {
        $sql = "INSERT INTO participations (id_user, id_trajet, date_inscription)
                VALUES (:id_user, :id_trajet, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':id_trajet', $id_trajet, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Récupère toutes les participations
     *
     * @return array
     */
    public function getAll(): array {
        $sql = "SELECT * FROM participations";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
