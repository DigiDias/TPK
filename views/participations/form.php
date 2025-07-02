<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//echo "<pre>SESSION (dans form.php) : ";
//print_r($_SESSION);
//echo "</pre>";

echo "<pre>SESSION (form.php) : ";
print_r($_SESSION);
echo "</pre>";

// Sécurité : vérifier que $id_trajet est bien défini
if (!isset($id_trajet)) {
    echo '<div class="alert alert-danger text-center mt-5">Erreur : Trajet non spécifié.</div>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Participer à un trajet</title>
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="mb-4">Participer à un trajet</h1>

    <form method="post" action="index.php?action=store-participation" class="card p-4 shadow-sm rounded">
        
        <input type="hidden" name="id_trajet" value="<?= htmlspecialchars($id_trajet ?? '') ?>">

        <p class="mb-3">Confirmez votre participation à ce trajet.</p>

        <button type="submit" class="btn btn-primary">Valider ma participation</button>
        <a href="index.php?action=listTrajets" class="btn btn-outline-secondary ms-2">← Retour à la liste des trajets</a>
    </form>
</div>

<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

