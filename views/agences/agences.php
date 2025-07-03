<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des agences</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4 fond text-center">Liste des agences</h1>

    <!-- Bouton pour créer une nouvelle agence -->
    <div class="mb-3 text-end">
        <a href="index.php?action=creerAgence" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Nouvelle agence
        </a>
    </div>

    <?php if (!empty($agences)): ?>
        <table class="table table-bordered table-hover">
            <thead class="fond text-white">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agences as $agence): ?>
                    <tr>
                        <td><?= htmlspecialchars($agence['id_agence']) ?></td>
                        <td><?= htmlspecialchars($agence['nom']) ?></td>
                        <td class="text-center">
                            <!-- Bouton modifier -->
                            <a href="index.php?action=modifierAgence&id_agence=<?= urlencode($agence['id_agence']) ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <!-- Bouton supprimer -->
                            <a href="index.php?action=supprimerAgence&id_agence=<?= urlencode($agence['id_agence']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette agence ?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning text-center">Aucune agence trouvée.</div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="index.php?action=listTrajets" class="btn btn-secondary">← Retour aux trajets</a>
    </div>
</div>

</body>
</html>
