<?php


namespace Controllers;
Use Models\Participation;
use PDO;


/**
 * Contrôleur ParticipationController
 * Gère les inscriptions aux trajets
 */
class ParticipationController
{
    /**
     * @var PDO Connexion à la base de données
     */
    private PDO $pdo;

    /**
     * Constructeur du contrôleur
     *
     * @param PDO $pdo Connexion PDO à la base de données
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Affiche le formulaire de participation à un trajet
     *
     * @param int $id_trajet Identifiant du trajet concerné
     * @return void
     */
public function form(int $id_trajet): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['user']['id'])) {
        $_SESSION['error'] = "Vous devez être connecté pour participer à un trajet.";
        header("Location: index.php?action=listTrajets");
        exit;
    }

    $idUtilisateur = intval($_SESSION['user']['id']);

    // Vérifie si l'utilisateur a déjà participé à ce trajet
    $check = $this->pdo->prepare("SELECT * FROM participations WHERE id_user = ? AND id_trajet = ?");
    $check->execute([$idUtilisateur, $id_trajet]);

    if ($check->fetch()) {
        $_SESSION['error'] = "Vous êtes déjà inscrit à ce trajet.";
        header("Location: index.php?action=listTrajets");
        exit;
    }

    // Sinon, affiche le formulaire de participation
    require __DIR__ . '/../views/participations/form.php';
}

    /**
     * Enregistre la participation de l'utilisateur au trajet sélectionné
     *
     * @return void
     */
    public function store(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // DEBUG : Affiche la session en cours pour vérifier l'état de l'utilisateur connecté
        // echo "<pre>SESSION (dans store) : ";
        // print_r($_SESSION);
        // echo "</pre>";
        // exit;

        // Vérification des paramètres obligatoires
        if (!isset($_SESSION['user']['id']) || !isset($_POST['id_trajet'])) {
            $_SESSION['error'] = "Vous devez être connecté pour participer à un trajet.";
            header("Location: index.php?action=login");
            exit;
        }

        $idUtilisateur = intval($_SESSION['user']['id']);
        $idTrajet = intval($_POST['id_trajet']);

        // Vérifie si l'utilisateur a déjà participé à ce trajet
        $check = $this->pdo->prepare("SELECT * FROM participations WHERE id_user = ? AND id_trajet = ?");
        $check->execute([$idUtilisateur, $idTrajet]);

        if ($check->fetch()) {
            $_SESSION['error'] = "Vous êtes déjà inscrit à ce trajet.";
            header("Location: index.php?action=listTrajets");
            exit;
        }

        // Vérifie le nombre de places disponibles
        $placesStmt = $this->pdo->prepare("SELECT places_dispo FROM trajets WHERE id_trajet = ?");
        $placesStmt->execute([$idTrajet]);
        $places = $placesStmt->fetchColumn();

        if (!$places || $places <= 0) {
            $_SESSION['error'] = "Aucune place disponible pour ce trajet.";
            header("Location: index.php?action=listTrajets");
            exit;
        }

        // Insère la participation
       // $participationModel = new Participation($this->pdo);
        //$participationModel->ajouterParticipation($idUtilisateur, $idTrajet);

        // Met à jour les places disponibles
       // $update = $this->pdo->prepare("UPDATE trajets SET places_dispo = places_dispo - 1 WHERE id_trajet = ?");
        //$update->execute([$idTrajet]);

        //$_SESSION['success'] = "Participation enregistrée avec succès.";
       // header("Location: index.php?action=listTrajets");
       // exit;
    }
}
