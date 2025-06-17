<?php
require_once __DIR__ . '/../../models/Capteur.php';
$data = Capteur::getLastButaneData(5);

$valeurs = array_column($data, 'value');
$min = min($valeurs);
$max = max($valeurs);
$avg = round(array_sum($valeurs) / count($valeurs), 1);
?>

<h2>🟠 Butane</h2>
<ul>
  <li>Min : <?= $min ?> ppm</li>
  <li>Max : <?= $max ?> ppm</li>
  <li>Moyenne : <?= $avg ?> ppm</li>
</ul>

<table class="live-table">
  <thead>
    <tr><th>Date</th><th>Taux Butane (ppm)</th></tr>
  </thead>
  <tbody>
    <?php foreach ($data as $row): ?>
      <tr>
        <td><?= $row['timestamp'] ?></td>
        <td><?= $row['value'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
