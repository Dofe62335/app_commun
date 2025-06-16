<?php
require_once __DIR__ . '/../../models/Capteur.php';
$data = Capteur::getLastCO2Data(5);

$valeurs = array_column($data, 'taux');
$min = min($valeurs);
$max = max($valeurs);
$avg = round(array_sum($valeurs) / count($valeurs), 1);
?>

<h2>🟢 CO₂</h2>
<ul>
  <li>Min : <?= $min ?> ppm</li>
  <li>Max : <?= $max ?> ppm</li>
  <li>Moyenne : <?= $avg ?> ppm</li>
</ul>

<table class="live-table">
  <thead>
    <tr><th>Date</th><th>Taux CO₂</th></tr>
  </thead>
  <tbody>
    <?php foreach ($data as $row): ?>
      <tr>
        <td><?= $row['date_time_taux'] ?></td>
        <td><?= $row['taux'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
