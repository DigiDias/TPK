
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

</head>
<body>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center bg-light" style="background-color: #f1f8fc;">
    <div class="card shadow-lg p-4 rounded-4" style="max-width: 420px; width: 100%;">
        <div class="text-center mb-4">
            <h1 class="fw-bold" style="color: #82b864;">TPK</h1>
            <h4 class="fw-semibold" style="color: #00497c;">Connexion</h4>
        </div>

        <?php if (!empty($error)) : ?>
            <div class="alert text-white" style="background-color: #cd2c2e;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/login">
            <div class="mb-3">
                <label for="email" class="form-label text-dark">Adresse e-mail</label>
                <input type="email" class="form-control border-0 shadow-sm" id="email" name="email" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-dark">Mot de passe</label>
                <input type="password" class="form-control border-0 shadow-sm" id="password" name="password" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn text-white fw-bold" style="background-color: #0074c7;">Se connecter</button>
            </div>
        </form>
    </div>
</div>
        </body>
</html>
