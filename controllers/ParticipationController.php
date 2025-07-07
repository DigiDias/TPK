<?php

namespace Controllers;

use Models\Participation;
use PDO;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contrôleur gérant les inscriptions aux trajets.
 */
class ParticipationController
{
    /**
     * Connexion à la base de données.
     *
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Constructeur du contrôleur.
     *
     * @param PDO $pdo Connexion PDO à la base de données
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Affiche le formulaire de participation à un trajet.
     *
     * @param int $id_trajet Identifiant du trajet concerné
     * @return Response
     */
    public function form(int $id_trajet): Response
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']['id'])) {
            $_SESSION['error'] = "Vous devez être connecté pour participer à un trajet.";
            header("Location: /trajets");
            exit;
        }

        $idUtilisateur = (int) $_SESSION['user']['id'];

        // Vérifie si l'utilisateur est déjà inscrit
        $check = $this->pdo->prepare("SELECT * FROM participations WHERE id_user = ? AND id_trajet = ?");
        $check->execute([$idUtilisateur, $id_trajet]);

        if ($check->fetch()) {
            $_SESSION['error'] = "Vous êtes déjà inscrit à ce trajet.";
            header("Location: /trajets");
            exit;
        }

        ob_start();
        require __DIR__ . '/../views/participations/form.php';
        $content = ob_get_clean();

        return new Response($content);
    }

    /**
     * Enregistre la participation de l'utilisateur au trajet.
     *
     * @return Response
     */
    public function store(): Response
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']['id']) || !isset($_POST['id_trajet'])) {
            $_SESSION['error'] = "Connexion requise.";
            header("Location: /login");
            exit;
        }

        $idUtilisateur = (int) $_SESSION['user']['id'];
        $idTrajet = (int) $_POST['id_trajet'];

        // Vérifie si l'utilisateur est déjà inscrit
        $check = $this->pdo->prepare("SELECT * FROM participations WHERE id_user = ? AND id_trajet = ?");
        $check->execute([$idUtilisateur, $idTrajet]);

        if ($check->fetch()) {
            $_SESSION['error'] = "Vous êtes déjà inscrit à ce trajet.";
            header("Location: /trajets");
            exit;
        }

        // Vérifie les places restantes
        $placesStmt = $this->pdo->prepare("SELECT places_dispo FROM trajets WHERE id_trajet = ?");
        $placesStmt->execute([$idTrajet]);
        $places = $placesStmt->fetchColumn();

        if (!$places || $places <= 0) {
            $_SESSION['error'] = "Plus aucune place disponible.";
            header("Location: /trajets");
            exit;
        }

        // Enregistrement de la participation
        $participation = $this->pdo->prepare("INSERT INTO participations (id_user, id_trajet) VALUES (?, ?)");
        $participation->execute([$idUtilisateur, $idTrajet]);

        // Mise à jour des places restantes
        $update = $this->pdo->prepare("UPDATE trajets SET places_dispo = places_dispo - 1 WHERE id_trajet = ?");
        $update->execute([$idTrajet]);

        $_SESSION['success'] = "Inscription confirmée.";
        header("Location: /trajets");
        exit;
    }
}
