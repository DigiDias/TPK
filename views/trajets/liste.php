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
    <title>Trajets proposés</title>
    <!-- CSS personnalisé + Bootstrap -->
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>


</head>

<!-- Flex column pour que le footer reste en bas -->
<body class="d-flex flex-column min-vh-100">

    <!-- Barre de navigation -->
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <!-- Contenu principal -->
    <main class="container my-5 flex-grow-1">


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



<div>          <?php if (!isset($_SESSION['user'])): ?>
    <div class="alerte">
        Pour obtenir plus d'informations sur les trajets, veuillez vous connecter.
    </div>
<?php else: ?>
    <h1 class="mb-4">Trajets proposés</h1>
<?php endif; ?>
</div>



      




        <!-- Tableau des trajets -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Départ</th>
                    <th>Date</th>
                    <th>Heure</th>
                     <th>Destination</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Places dispo</th>
                   
                                       <?php if (isset($_SESSION['user'])): ?>
                        <th>Action</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trajets as $trajet): ?>
                    <tr>

<!-- Modal Voir -->
<div class="modal fade" id="modalVoir<?= $trajet['id_trajet'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $trajet['id_trajet'] ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel<?= $trajet['id_trajet'] ?>">Détails du trajet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
      <p><strong>Créateur :</strong>
    <?= htmlspecialchars(($trajet['createur_prenom'] ?? '') . ' ' . ($trajet['createur_nom'] ?? '')) ?: 'N/A' ?>
</p>
        <p><strong>Email :</strong> <?= htmlspecialchars($trajet['contact_email']) ?></p>
        <p><strong>Téléphone :</strong> <?= htmlspecialchars($trajet['contact_tel']) ?></p>
        <p><strong>Places disponibles :</strong> <?= htmlspecialchars($trajet['places_dispo']) ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

                        <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                        <td><?= htmlspecialchars($trajet['date_depart']) ?></td>
                        <td><?= htmlspecialchars($trajet['heure_depart']) ?></td>
                        <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                        
                        <td><?= htmlspecialchars($trajet['date_arrivee']) ?></td>
                        <td><?= htmlspecialchars($trajet['heure_arrivee']) ?></td>
                        <td><?= htmlspecialchars($trajet['places_dispo']) ?></td>
                   
                        
                         <?php if (isset($_SESSION['user'])): ?>
                        <td>
    <!-- Bouton Voir (toujours visible) -->
    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalVoir<?= $trajet['id_trajet'] ?>">
        <i class="bi bi-eye"></i>
    </button>
      <?php endif; ?>

  <!-- Boutons Modifier et Supprimer (pour le créateur OU un admin) -->
    <?php if (
        isset($_SESSION['user']) &&
        (
            $_SESSION['user']['id'] == $trajet['id_createur'] ||
            $_SESSION['user']['role'] === 'admin'
        )
    ): ?>
       <a href="/trajets/modifier/<?= urlencode($trajet['id_trajet']) ?>" class="btn btn-sm btn-warning">
    <i class="bi bi-pencil"></i>
</a>
        <a href="/trajets/supprimer/<?= urlencode($trajet['id_trajet']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce trajet ?');">
            <i class="bi bi-trash"></i>
        </a>
    <?php endif; ?>
</td>
                        
                        <!-- <td>
                            <a href="index.php?action=participer&id_trajet=<?= urlencode($trajet['id_trajet']) ?>" class="btn btn-sm btn-primary">
                                Participer
                            </a>
                        </td> -->
                      
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </main>

    <!-- Pied de page -->
    <?php include __DIR__ . '/../partials/footer.php'; ?>

  
 
</body>
</html>
