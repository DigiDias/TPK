<?php
// Démarrage de la session si ce n’est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des trajets</title>
    <!-- CSS personnalisé + Bootstrap -->
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<!-- Flex column pour que le footer reste en bas -->
<body class="d-flex flex-column min-vh-100">

    <!-- Barre de navigation -->
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <!-- Contenu principal -->
    <main class="container my-5 flex-grow-1">

        <h1 class="mb-4">Liste des trajets</h1>

        <!-- Message de succès -->
<?php if (!empty($_SESSION['error'])): ?>
    <div id="flash-error" class="alert alert-danger text-center">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div id="flash-success" class="alert alert-success text-center">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

        <!-- Tableau des trajets -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Départ</th>
                    <th>Arrivée</th>
                    <th>Date départ</th>
                    <th>Date arrivée</th>
                    <th>Places dispo</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trajets as $trajet): ?>
                    <tr>
                        <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                        <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                        <td><?= htmlspecialchars($trajet['date_depart']) ?></td>
                        <td><?= htmlspecialchars($trajet['date_arrivee']) ?></td>
                        <td><?= htmlspecialchars($trajet['places_dispo']) ?></td>
                        <td><?= htmlspecialchars($trajet['contact_email']) ?></td>
                        <td>
                            <a href="index.php?action=participer&id_trajet=<?= urlencode($trajet['id_trajet']) ?>" class="btn btn-sm btn-primary">
                                Participer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </main>

    <!-- Pied de page -->
    <?php include __DIR__ . '/../partials/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
