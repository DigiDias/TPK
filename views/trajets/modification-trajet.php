<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../models/Trajet.php';
require_once __DIR__ . '/../../models/Agence.php';

$trajetModel = new Trajet();
$agenceModel = new Agence();

$trajet = $trajetModel->getById($_GET['id_trajet']);
$agences = $agenceModel->getAll(); // pour les listes déroulantes

if (!$trajet || $_SESSION['user']['id'] != $trajet['id_createur']) {
    die('Accès non autorisé.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le trajet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container my-5">

    <h1 class="mb-4">Modifier le trajet</h1>

    <form method="post" action="index.php?action=updateTrajet&id_trajet=<?= $trajet['id_trajet'] ?>">
        
        <!-- Agence départ -->
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Agence de départ</label>
            <div class="col-sm-6">
                <select name="agence_depart_id" class="form-select">
                    <?php foreach ($agences as $agence): ?>
                        <option value="<?= $agence['id_agence'] ?>" <?= $agence['id_agence'] == $trajet['agence_depart_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($agence['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Agence arrivée -->
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Agence d'arrivée</label>
            <div class="col-sm-6">
                <select name="agence_arrivee_id" class="form-select">
                    <?php foreach ($agences as $agence): ?>
                        <option value="<?= $agence['id_agence'] ?>" <?= $agence['id_agence'] == $trajet['agence_arrivee_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($agence['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Date et heure de départ -->
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Date de départ</label>
            <div class="col-sm-3">
                <input type="date" name="date_depart" class="form-control" value="<?= $trajet['date_depart'] ?>">
            </div>
            <div class="col-sm-3">
                <input type="time" name="heure_depart" class="form-control" value="<?= $trajet['heure_depart'] ?>">
            </div>
        </div>

        <!-- Date et heure d’arrivée -->
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">Date d’arrivée</label>
            <div class="col-sm-3">
                <input type="date" name="date_arrivee" class="form-control" value="<?= $trajet['date_arrivee'] ?>">
            </div>
            <div class="col-sm-3">
                <input type="time" name="heure_arrivee" class="form-control" value="<?= $trajet['heure_arrivee'] ?>">
            </div>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="index.php?action=listTrajets" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</body>
</html>
