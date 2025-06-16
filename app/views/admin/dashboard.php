<?php
require_once __DIR__ . '/../../controllers/AuthController.php';
require_once __DIR__ . '/../../controllers/AdminController.php';

AuthController::isAuthenticated('admin');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $message = AdminController::createProf($_POST['email'], $_POST['password']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $message = AdminController::deleteUser($_POST['delete_id'])
        ? "Compte supprimé avec succès."
        : "Erreur lors de la suppression.";
}

$profs = AdminController::getAllProfs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Volpe</title>
    <link rel="stylesheet" href="/volpe-site/public/assets/css/admin.css">
</head>
<script>
  setTimeout(() => {
    const alertBox = document.querySelector('.alert');
    if (alertBox) alertBox.style.display = 'none';
  }, 3000); // 3 sec
</script>

<body>
    <header class="admin-header">
        <h1>Volpe — Espace Admin</h1>
        <a href="/volpe-site/app/views/auth/logout.php" class="logout-btn">🔓 Déconnexion</a>
    </header>

    <main class="admin-main">
        <?php if (!empty($message)): ?>
            <div class="alert"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <section class="left-panel">
            <h2>Créer un compte professeur</h2>
            <form method="POST" class="create-form">
                <input type="hidden" name="create" value="1">
                <input type="email" name="email" placeholder="Email du prof" required>
                <input type="password" name="password" placeholder="Mot de passe initial" required>
                <button type="submit">Créer</button>
            </form>
        </section>

        <section class="right-panel">
            <h2>Liste des professeurs</h2>
            <?php if (!empty($profs) && count($profs) > 0): ?>
                <ul class="user-list">
                    <?php foreach ($profs as $prof): ?>
                        <li>
                            <?= htmlspecialchars($prof['email']) ?> — créé le <?= $prof['created_at'] ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?= $prof['id'] ?>">
                                <button type="submit" class="danger">Supprimer</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun professeur enregistré pour le moment.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
