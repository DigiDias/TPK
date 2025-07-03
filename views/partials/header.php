<header class="tpk-header">
    <div class="left">
        <a href="index.php" class="logo">Touche pas au Klaxon</a>
    </div>
    <div class="right">
        <?php if (!isset($_SESSION['user'])): ?>
            <a href="index.php?action=login" class="btn">Connexion</a>
        <?php else: ?>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <nav class="admin-nav">
                  <a href="index.php?action=utilisateurs">Utilisateurs</a>
                    <a href="index.php?action=agences">Agences</a>
                    <a href="index.php?action=trajets">Trajets</a>
         
                    
                 
                    <a href="index.php?action=logout" class="btn">Déconnexion</a>
                </nav>
                      <?php else: ?>
                <a href="index.php?action=create-trajet" class="btn">Créer un trajet</a>
                <span class="user-name">Bonjour <?= htmlspecialchars($_SESSION['user']['prenom']) ?> <?= htmlspecialchars($_SESSION['user']['nom']) ?></span>
                <a href="index.php?action=logout" class="btn">Déconnexion</a
                
            <?php endif; ?>
        <?php endif; ?>
    </div>
</header>
