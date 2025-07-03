<?php

namespace Models;

use Config\Database;
use PDO;

/**
 * Classe Participation
 *
 * Gère les interactions avec la table `participations`.
 */
class Participation
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
     * Initialise la connexion avec une instance de PDO.
     *
     * @param PDO $pdo Instance PDO injectée.
     */
    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    /**
     * Enregistre une nouvelle participation à un trajet.
     *
     * @param int $id_user   ID de l'utilisateur qui participe.
     * @param int $id_trajet ID du trajet auquel participer.
     * @return bool          True si insertion réussie, false sinon.
     */
    public function ajouterParticipation(int $id_user, int $id_trajet): bool
    {
        $sql = "INSERT INTO participations (id_user, id_trajet, date_inscription)
                VALUES (:id_user, :id_trajet, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':id_trajet', $id_trajet, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Récupère toutes les participations enregistrées.
     *
     * @return array Tableau associatif des participations.
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM participations";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
