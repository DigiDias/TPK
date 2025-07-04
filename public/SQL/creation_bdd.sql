Script de création de la base de donnée

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS digidias_tpk_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE digidias_tpk_db;

-- Table des agences
CREATE TABLE IF NOT EXISTS agences (
    id_agence INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id_user INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20),
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT NULL
);
-- Table des trajets
CREATE TABLE IF NOT EXISTS trajets (
    id_trajet INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_createur INT(11) NOT NULL,
    agence_depart_id INT(11) NOT NULL,
    agence_arrivee_id INT(11) NOT NULL,
    date_depart DATE NOT NULL,
    date_arrivee DATE NOT NULL,
    heure_depart TIME NOT NULL,
    heure_arrivee TIME NOT NULL,
    places_total INT(11) NOT NULL,
    places_dispo INT(11) NOT NULL,
    contact_tel VARCHAR(20) NOT NULL,
    contact_email VARCHAR(150) NOT NULL,
    
    -- Clés étrangères
    CONSTRAINT fk_trajets_createur FOREIGN KEY (id_createur) REFERENCES users(id_user),
    CONSTRAINT fk_trajets_agence_depart FOREIGN KEY (agence_depart_id) REFERENCES agences(id_agence),
    CONSTRAINT fk_trajets_agence_arrivee FOREIGN KEY (agence_arrivee_id) REFERENCES agences(id_agence)
);
-- Table des participations
CREATE TABLE IF NOT EXISTS participations (
    id_participation INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_user INT(11) NOT NULL,
    id_trajet INT(11) NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,

    -- Clés étrangères
    CONSTRAINT fk_participations_user FOREIGN KEY (id_user) REFERENCES users(id_user),
    CONSTRAINT fk_participations_trajet FOREIGN KEY (id_trajet) REFERENCES trajets(id_trajet)
);
