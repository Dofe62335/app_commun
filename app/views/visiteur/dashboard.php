<?php
require_once __DIR__ . '/../../controllers/AuthController.php';
require_once __DIR__ . '/../../controllers/VisiteurDashboardController.php';

AuthController::isAuthenticated('visiteur');
$data = VisiteurDashboardController::getDashboardData();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Visiteur - Volpe</title>
  <link rel="stylesheet" href="/volpe-site/public/assets/css/visiteur.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="/volpe-site/public/assets/js/temperature.js" defer></script>
</head>
<body>
  <header class="visiteur-header">
    <h1>Volpe — Espace Visiteur 👀</h1>
    <a href="/volpe-site/app/views/auth/logout.php" class="logout-btn">🔓 Déconnexion</a>
  </header>

  <main class="visiteur-content">

    <!-- Température - Graph -->
    <section class="info-box">
      <h2>🌡️ Température</h2>
      <canvas id="temperatureChart" height="120"></canvas>
      <ul>
        <li>Min : <span id="temp-min">-</span> °C</li>
        <li>Max : <span id="temp-max">-</span> °C</li>
        <li>Moyenne : <span id="temp-avg">-</span> °C</li>
      </ul>
    </section>

    <!-- Température actuelle -->
    <section class="info-box temp-current">
      <h2>🔥 Température actuelle</h2>
      <div class="temp-value"><?= $data['lastTemp'] ?? '--' ?> °C</div>
    </section>

    <!-- Présence -->
    <section class="info-box presence-box">
      <h2>👥 Présence actuelle</h2>
      <div class="counter">
         <?= $data['presence'] ?>/20 élèves présents
      </div>
    </section>

    <!-- Buzzers actifs -->
    <section class="info-box buzzers">
      <h2>🔊 Buzzers actifs</h2>
      <?php if (!empty($data['buzzers'])): ?>
        <ul>
          <?php foreach ($data['buzzers'] as $buzzer): ?>
            <li>🔴 <?= $buzzer['freq'] ?> Hz – <?= $buzzer['duration'] ?> ms × <?= $buzzer['repetition'] ?></li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>🔇 Aucun buzzer actif</p>
      <?php endif; ?>
    </section>

  </main>
</body>
</html>
