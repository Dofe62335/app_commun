<?php
require_once __DIR__ . '/../../controllers/AuthController.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = AuthController::register($_POST['email'], $_POST['password'], 'visiteur');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Volpe</title>
    <link rel="stylesheet" href="/volpe-site/public/assets/css/auth.css">
</head>
<body>
    <div class="login-container">
        <h2>Inscription Visiteur</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">S’inscrire</button>
        </form>
        <?php if ($message): ?>
            <p style="color: red;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <div class="back-home">
            <a href="/volpe-site/public/index.php">← Retour à la page d'accueil</a>
        </div>

</body>
</html>
