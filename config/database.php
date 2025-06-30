<?php
// config/database.php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Chargement des variables d’environnement depuis le fichier .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

/**
 * Classe Database
 *
 * Gère la connexion à la base de données MySQL via PDO,
 * en utilisant les paramètres définis dans le fichier .env.
 */
class Database {
    /**
     * @var string Nom d’hôte du serveur MySQL
     */
    private $host;

    /**
     * @var string Nom de la base de données
     */
    private $dbname;

    /**
     * @var string Nom d’utilisateur MySQL
     */
    private $username;

    /**
     * @var string Mot de passe de connexion
     */
    private $password;

    /**
     * @var PDO|null Instance PDO de la connexion (null si non connecté)
     */
    public $pdo;

    /**
     * Constructeur
     *
     * Récupère les informations de connexion à la base de données
     * à partir des variables d’environnement chargées depuis .env.
     */
    public function __construct() {
        $this->host = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    /**
     * Établit une connexion PDO à la base de données
     *
     * @return PDO L’objet PDO connecté à la base
     *
     * @throws PDOException Si la connexion échoue
     */
    public function getConnection() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
