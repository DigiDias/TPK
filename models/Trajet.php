<?php

require_once __DIR__ . '/../config/database.php';

/**
 * Classe Trajet
 * 
 * Gère les interactions avec la table des trajets.
 */
class Trajet
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
     * Initialise la connexion à la base de données.
     */
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Récupère tous les trajets à venir avec :
     * - Le nom des agences de départ et d'arrivée
     * - Le nom du créateur du trajet
     *
     * @return array Liste des trajets sous forme de tableau associatif
     */
    public function getAll(): array
    {
        $sql = "SELECT t.*, 
                       a1.nom AS agence_depart, 
                       a2.nom AS agence_arrivee,
                       u.nom AS createur_nom,
                       u.id_user AS id_createur_user
                FROM trajets t
                JOIN agences a1 ON t.agence_depart_id = a1.id_agence
                JOIN agences a2 ON t.agence_arrivee_id = a2.id_agence
                JOIN users u ON t.id_createur = u.id_user
                WHERE t.date_depart >= CURDATE()
                AND t.places_dispo > 0
                ORDER BY t.date_depart ASC, t.heure_depart ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouveau trajet dans la base de données.
     *
     * @param array $data Données du trajet à insérer :
     *   - agence_depart_id (int)
     *   - agence_arrivee_id (int)
     *   - date_depart (string, format YYYY-MM-DD)
     *   - heure_depart (string, format HH:MM:SS)
     *   - date_arrivee (string, format YYYY-MM-DD)
     *   - heure_arrivee (string, format HH:MM:SS)
     *   - places_total (int)
     *   - places_dispo (int)
     *   - contact_tel (string)
     *   - contact_email (string)
     *   - id_createur (int)
     * @return bool True si l'insertion réussit, false sinon
     */
    public function creerTrajet(array $data): bool
    {
        $sql = "INSERT INTO trajets (
                    agence_depart_id,
                    agence_arrivee_id,
                    date_depart,
                    heure_depart,
                    date_arrivee,
                    heure_arrivee,
                    places_total,
                    places_dispo,
                    contact_tel,
                    contact_email,
                    id_createur
                ) VALUES (
                    :depart,
                    :arrivee,
                    :date_depart,
                    :heure_depart,
                    :date_arrivee,
                    :heure_arrivee,
                    :places_total,
                    :places_dispo,
                    :tel,
                    :email,
                    :createur
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':depart'        => $data['agence_depart_id'],
            ':arrivee'       => $data['agence_arrivee_id'],
            ':date_depart'   => $data['date_depart'],
            ':heure_depart'  => $data['heure_depart'],
            ':date_arrivee'  => $data['date_arrivee'],
            ':heure_arrivee' => $data['heure_arrivee'],
            ':places_total'  => $data['places_total'],
            ':places_dispo'  => $data['places_dispo'],
            ':tel'           => $data['contact_tel'],
            ':email'         => $data['contact_email'],
            ':createur'      => $data['id_createur']
        ]);
    }


public function getById(int $id): ?array
{
    $sql = "SELECT * FROM trajets WHERE id_trajet = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    $trajet = $stmt->fetch(PDO::FETCH_ASSOC);
    return $trajet ?: null;
}

public function updateTrajet(int $id, array $data): bool
{
    $sql = "UPDATE trajets SET
                agence_depart_id = :depart,
                agence_arrivee_id = :arrivee,
                date_depart = :date_depart,
                heure_depart = :heure_depart,
                date_arrivee = :date_arrivee,
                heure_arrivee = :heure_arrivee,
                places_dispo= :places_dispo
            WHERE id_trajet = :id";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':depart'        => $data['agence_depart_id'],
        ':arrivee'       => $data['agence_arrivee_id'],
        ':date_depart'   => $data['date_depart'],
        ':heure_depart'  => $data['heure_depart'],
        ':date_arrivee'  => $data['date_arrivee'],
        ':heure_arrivee' => $data['heure_arrivee'],
        ':places_dispo' => $data['places_dispo'],
        ':id'            => $id
    ]);
}

}
