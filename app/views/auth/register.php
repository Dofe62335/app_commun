<?php
require_once __DIR__ . '/../../controllers/AuthController.php';

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = AuthController::register(
        $_POST['email'] ?? '',
        $_POST['password'] ?? '',
        $_POST['confirm_password'] ?? '',
        'visiteur', // rôle forcé pour plus de sécurité
        isset($_POST['terms'])
    );
    $message = $result['message'];
    if ($result['code'] == 1) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inscription – SmartClass</title>
  
  <link rel="stylesheet" href="/volpe-site/public/assets/css/accueil.css">
  <link rel="stylesheet" href="/volpe-site/public/assets/css/auth_register.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
</head>
<body>



<main>
  <div class="register-container">
    <h1>Inscription Visiteur</h1>

    <form method="POST" id="register-form">
      <input type="hidden" name="role" value="visiteur" />

      <label for="email">Adresse mail</label>
      <input type="text" id="email" name="email" placeholder="Votre adresse email" />

      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" placeholder="Votre mot de passe" />

      <label for="confirm_password">Confirmez le mot de passe</label>
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmez votre mot de passe" />


      <div style="text-align:center;">
        <button type="submit" class="btn">Créer un compte</button>
      </div>
    </form>

    <?php if ($message): ?>
        <p style="color: red;<?= $success ? 'display:none;' : '' ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <div class="back-home">
        <a href="/volpe-site/public/index.php">← Retour à la page d'accueil</a>
    </div>

    <?php if ($success): ?>
    <div id="successModal" style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;z-index:9999;">
        <div style="background:#fff;padding:2rem 2.5rem;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.2);text-align:center;min-width:300px;">
            <div style="display:flex;justify-content:center;margin-bottom:1rem;">
                <div class="loader" style="border: 6px solid #f3f3f3; border-top: 6px solid #2e7d32; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite;"></div>
            </div>
            <h2 style="color:#2e7d32;margin-bottom:1rem;">Inscription réussie !</h2>
            <p>Redirection vers la page de connexion...</p>
        </div>
    </div>
    <script>
        setTimeout(function(){
            window.location.href = '/volpe-site/app/views/auth/login.php';
        }, 2000);
    </script>
    <?php endif; ?>
  </div>
</main>

<script src="/volpe-site/public/assets/js/auth_register.js"></script>
</body>
</html>
