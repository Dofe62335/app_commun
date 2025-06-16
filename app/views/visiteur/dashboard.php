<?php
require_once __DIR__ . '/../../controllers/AuthController.php';
AuthController::isAuthenticated('visiteur');
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
    <!-- Température -->
    <section class="info-box">
      <h2>🌡️ Température</h2>
      <canvas id="temperatureChart" height="120"></canvas>
      <ul>
        <li>Min : <span id="temp-min">-</span> °C</li>
        <li>Max : <span id="temp-max">-</span> °C</li>
        <li>Moyenne : <span id="temp-avg">-</span> °C</li>
      </ul>
    </section>

    <!-- Présence -->
    <section class="presence-box">
      <h2>👥 Présence actuelle</h2>
      <div class="counter">
         <span id="presence-count">-</span> élèves présents
      </div>
    </section>
  </main>

  <script>
    async function updatePresence() {
      const res = await fetch('/volpe-site/app/views/visiteur/presence_data.php');
      const json = await res.json();
      document.getElementById('presence-count').textContent = json.count;
    }
    setInterval(updatePresence, 10000);
    updatePresence();
  </script>
</body>
</html>
