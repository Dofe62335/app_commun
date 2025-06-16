<?php
require_once __DIR__ . '/../../controllers/AuthController.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = AuthController::login($_POST['email'], $_POST['password']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="/volpe-site/public/assets/css/auth.css">
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>

        <?php if ($message): ?>
            <p style="color: red;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <div class="back-home">
            <a href="/volpe-site/public/index.php">← Retour à la page d'accueil</a>
        </div>
    </div>
</body>
</html>
