<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un trajet</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg">
                <div class="fond text-white text-center">
                    <h3 class="mb-0">Créer un nouveau trajet</h3>
                </div>

                <div class="card-body">
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <form method="post" action="/trajets">
                        <!-- Agence de départ -->
                        <div class="mb-3">
                            <label for="agence_depart_id" class="form-label">Agence de départ</label>
                            <select name="agence_depart_id" id="agence_depart_id" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                <?php foreach ($agences as $agence): ?>
                                    <option value="<?= $agence['id_agence'] ?>"><?= htmlspecialchars($agence['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Agence d'arrivée -->
                        <div class="mb-3">
                            <label for="agence_arrivee_id" class="form-label">Agence d'arrivée</label>
                            <select name="agence_arrivee_id" id="agence_arrivee_id" class="form-select" required>
                                <option value="">-- Sélectionner --</option>
                                <?php foreach ($agences as $agence): ?>
                                    <option value="<?= $agence['id_agence'] ?>"><?= htmlspecialchars($agence['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Dates et heures -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_depart" class="form-label">Date de départ</label>
                                <input type="date" name="date_depart" id="date_depart" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="heure_depart" class="form-label">Heure de départ</label>
                                <input type="time" name="heure_depart" id="heure_depart" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_arrivee" class="form-label">Date d’arrivée</label>
                                <input type="date" name="date_arrivee" id="date_arrivee" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="heure_arrivee" class="form-label">Heure d’arrivée</label>
                                <input type="time" name="heure_arrivee" id="heure_arrivee" class="form-control" required>
                            </div>
                        </div>

                        <!-- Places disponibles -->
                        <div class="mb-3">
                            <label for="places_dispo" class="form-label">Nombre de places disponibles</label>
                            <input type="number" name="places_dispo" id="places_dispo" class="form-control" min="1" required>
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between">
                            <a href="/trajets" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-success">Créer le trajet</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>
