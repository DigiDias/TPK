<?php

require_once __DIR__ . '/../models/Trajet.php';

/**
 * Classe TrajetController
 * 
 * Contrôleur chargé de gérer l'affichage des trajets.
 */
class TrajetController {

    /**
     * Méthode principale pour afficher la liste des trajets.
     *
     * Récupère les trajets via le modèle et charge la vue associée.
     *
     * @return void
     */
    public function liste() {
        $trajetModel = new Trajet(); // instancie le modèle
        $trajets = $trajetModel->getAll(); // récupère les trajets

        // affiche la vue en passant les données
        require __DIR__ . '/../views/trajets/liste.php';
    }
}
