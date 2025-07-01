<?php include __DIR__ . '/../partials/header.php'; ?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des trajets</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1>Liste des trajets</h1>

    <table border="1">
        <tr>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Date départ</th>
            <th>Date arrivée</th>
            <th>Places dispo</th>
            <th>Contact</th>
            <th>Action</th>
        </tr>
        <?php foreach ($trajets as $trajet): ?>
            <tr>
                <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                <td><?= $trajet['date_depart'] ?></td>
                <td><?= $trajet['date_arrivee'] ?></td>
                <td><?= $trajet['places_dispo'] ?></td>
                <td><?= $trajet['contact_email'] ?></td>
                <td>
                    <a href="index.php?action=participer&id_trajet=<?= $trajet['id_trajet'] ?>">
                        Participer
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
<?php include __DIR__ . '/../partials/footer.php'; ?>
</html>
