<?php

require_once __DIR__ . '/../config/database.php';

/**
 * Classe Trajet
 * 
 * Gère les interactions avec la table des trajets.
 */
class Trajet {
    
    /**
     * Instance PDO pour la connexion à la base de données
     * 
     * @var PDO
     */
    private $db;

    /**
     * Constructeur
     * 
     * Initialise la connexion à la base de données.
     */
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Récupère tous les trajets avec le nom des agences de départ et d'arrivée
     *
     * @return array Liste des trajets sous forme de tableau associatif
     */
    public function getAll() {
        $sql  = "SELECT t.*, a1.nom AS agence_depart, a2.nom AS agence_arrivee
                FROM trajets t
                JOIN agences a1 ON t.agence_depart_id = a1.id_agence
                JOIN agences a2 ON t.agence_arrivee_id = a2.id_agence"
                . " WHERE t.date_depart >= NOW()"
                . " AND t.places_dispo > 0"
                . " ORDER BY t.date_depart ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
