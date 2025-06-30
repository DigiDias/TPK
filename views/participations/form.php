<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Participer à un trajet</title>
</head>
<body>
    <h1>Participer à un trajet</h1>

    <form action="/index.php?action=storeParticipation" method="POST">
        <input type="hidden" name="id_trajet" value="<?= htmlspecialchars($id_trajet) ?>">

        <label for="id_user">Utilisateur :</label>
        <input type="number" name="id_user" id="id_user" required><br><br>

        <button type="submit">Participer</button>
    </form>

    <p><a href="/index.php">← Retour à la liste des trajets</a></p>
</body>
</html>
