<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isEditing = isset($agence); // Si on modifie ou on crée
$actionUrl = $isEditing
    ? "index.php?action=modifierAgence&id_agence=" . urlencode($agence['id_agence'])
    : "index.php?action=creerAgence";
$nomValue = $isEditing ? htmlspecialchars($agence['nom']) : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $isEditing ? "Modifier une agence" : "Créer une agence" ?></title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="fond p-3 text-white text-center">
                    <h3 class="mb-0"><?= $isEditing ? "Modifier l'agence" : "Créer une nouvelle agence" ?></h3>
                </div>

                <div class="card-body">
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($_SESSION['error']) ?>
                            <?php unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= $actionUrl ?>">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de l’agence</label>
                            <input type="text" name="nom" id="nom" class="form-control" value="<?= $nomValue ?>" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?action=List-agences" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-success"><?= $isEditing ? "Enregistrer les modifications" : "Créer" ?></button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
