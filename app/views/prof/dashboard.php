<?php
require_once __DIR__ . '/../../controllers/AuthController.php';
require_once __DIR__ . '/../../controllers/ProfDashboardController.php';

AuthController::isAuthenticated('prof');
$data = ProfDashboardController::getDashboardData();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Prof - Volpe</title>
  <link rel="stylesheet" href="/volpe-site/public/assets/css/prof.css">

  <!-- Librairies JS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

  <!-- Scripts perso -->
  <script src="/volpe-site/public/assets/js/temperature.js" defer></script>
  <script src="/volpe-site/public/assets/js/presence.js" defer></script>

  <script>
    function fetchGazData() {
      fetch('/volpe-site/app/views/prof/gaz_data.php')
        .then(response => response.text())
        .then(html => {
          document.getElementById('gaz-section').innerHTML = html;
        });
    }
    setInterval(fetchGazData, 10000);
    window.onload = fetchGazData;
  </script>
</head>
<body>
  <header class="prof-header">
    <div class="left">
      <h1>Volpe — Espace Professeur 👨‍🏫</h1>
    </div>
    <div class="right">
      <a href="/volpe-site/export/export_pdf.php" class="header-btn">📄 Exporter PDF</a>
      <a href="/volpe-site/app/views/auth/logout.php" class="logout-btn">🔓 Déconnexion</a>
    </div>
  </header>

  <main class="prof-content">

    <!-- 🌡️ Température -->
    <section class="info-box">
      <h2>🌡️ Température</h2>
      <canvas id="temperatureChart" height="120"></canvas>
      <ul>
        <li>Min : <span id="temp-min">-</span> °C</li>
        <li>Max : <span id="temp-max">-</span> °C</li>
        <li>Moyenne : <span id="temp-avg">-</span> °C</li>
      </ul>
    </section>

    <!-- 🟢 CO2 -->
    <section class="info-box" id="gaz-section">
      <p>Chargement des données CO₂...</p>
    </section>

    <!-- 👥 Présence -->
    <section class="info-box">
      <h2>👥 Présence</h2>
      <label for="class-select">Sélectionnez une classe :</label>
      <select id="class-select" onchange="updatePresence()">
        <option value="G3">G3 (20 élèves)</option>
        <option value="G4">G4 (18 élèves)</option>
        <option value="G5">G5 (22 élèves)</option>
      </select>
      <p id="presence-display">Présence actuelle : -</p>
      <canvas id="presenceChart" height="120"></canvas>
    </section>

  </main>
</body>
</html>
