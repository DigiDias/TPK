<?php

require_once __DIR__ . '/../models/Participation.php';

/**
 * Contrôleur pour la gestion des participations aux trajets.
 */
class ParticipationController
{
    /**
     * Affiche le formulaire d’inscription à un trajet.
     *
     * @param int $id_trajet L’identifiant du trajet sélectionné
     */
    public function form($id_trajet)
    {
        require __DIR__ . '/../views/participations/form.php';
    }

    /**
     * Traite la soumission du formulaire de participation.
     */
    public function store()
    {
        if (isset($_POST['id_user'], $_POST['id_trajet'])) {
            $participationModel = new Participation();
            $success = $participationModel->ajouterParticipation($_POST['id_user'], $_POST['id_trajet']);

            if ($success) {
                echo "Participation enregistrée avec succès.";
            } else {
                echo "Erreur lors de l'enregistrement.";
            }
        } else {
            echo "Paramètres manquants.";
        }
    }
}
