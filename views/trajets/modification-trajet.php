<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// $trajet et $agences sont fournis par le contrôleur
if (!$trajet || $_SESSION['user']['id'] != $trajet['id_createur']) {
    die('Accès non autorisé.');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le trajet</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h1 class="text-center mb-4 fond">Modifier le trajet</h1>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/trajets/modifier/<?= $trajet['id_trajet'] ?>">

        <div class="mb-3">
            <label for="agence_depart_id" class="form-label">Agence de départ</label>
            <select name="agence_depart_id" id="agence_depart_id" class="form-select" required>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= $agence['id_agence'] ?>" <?= $agence['id_agence'] == $trajet['agence_depart_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($agence['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="agence_arrivee_id" class="form-label">Agence d'arrivée</label>
            <select name="agence_arrivee_id" id="agence_arrivee_id" class="form-select" required>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= $agence['id_agence'] ?>" <?= $agence['id_agence'] == $trajet['agence_arrivee_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($agence['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="date_depart" class="form-label">Date de départ</label>
                <input type="date" name="date_depart" id="date_depart" class="form-control" value="<?= $trajet['date_depart'] ?>" required>
            </div>
            <div class="col">
                <label for="heure_depart" class="form-label">Heure de départ</label>
                <input type="time" name="heure_depart" id="heure_depart" class="form-control" value="<?= $trajet['heure_depart'] ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="date_arrivee" class="form-label">Date d’arrivée</label>
                <input type="date" name="date_arrivee" id="date_arrivee" class="form-control" value="<?= $trajet['date_arrivee'] ?>" required>
            </div>
            <div class="col">
                <label for="heure_arrivee" class="form-label">Heure d’arrivée</label>
                <input type="time" name="heure_arrivee" id="heure_arrivee" class="form-control" value="<?= $trajet['heure_arrivee'] ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="places_dispo" class="form-label">Places disponibles</label>
            <input type="number" name="places_dispo" id="places_dispo" class="form-control" value="<?= $trajet['places_dispo'] ?>"  required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="/trajets" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
        </div>
    </form>
</div>

</body>
</html>
