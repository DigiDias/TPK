<header class="tpk-header">
    <div class="left">
        <a href="index.php" class="logo">Touche pas au Klaxon</a>
    </div>
    <div class="right">
        <?php if (!isset($_SESSION['user'])): ?>
            <a href="/login" class="btn">Connexion</a>
         
        <?php else: ?>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <nav class="admin-nav">
                  <a href="/utilisateurs">Utilisateurs</a>
                    <a href="/agences">Agences</a>
                    <a href="/trajets">Trajets</a>
         
                    
                 
                    <a href="/logout" class="btn">Déconnexion</a>
                </nav>
                      <?php else: ?>
                <a href="/trajets/creer" class="btn">Créer un trajet</a>
                <span class="user-name">Bonjour <?= htmlspecialchars($_SESSION['user']['prenom']) ?> <?= htmlspecialchars($_SESSION['user']['nom']) ?></span>
                <a href="/logout" class="btn">Déconnexion</a
                
            <?php endif; ?>
        <?php endif; ?>
    </div>
</header>
