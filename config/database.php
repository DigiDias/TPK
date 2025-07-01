<?php
// config/database.php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

/**
 * Classe Database
 * 
 * Gère la connexion PDO à la base de données en utilisant les variables d’environnement.
 */
class Database {
    /**
     * @var string Nom d’hôte du serveur MySQL
     */
    private string $host;

    /**
     * @var string Nom de la base de données
     */
    private string $dbname;

    /**
     * @var string Nom d’utilisateur
     */
    private string $username;

    /**
     * @var string Mot de passe
     */
    private string $password;

    /**
     * @var PDO|null Connexion PDO
     */
    public ?PDO $pdo = null;

    /**
     * Constructeur
     * Initialise les informations de connexion à partir du fichier .env
     */
    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->host = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    /**
     * Récupère une instance PDO connectée à la base
     *
     * @return PDO
     */
    public function getConnection(): PDO {
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
