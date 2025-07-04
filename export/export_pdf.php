<?php
require_once __DIR__ . '/../app/models/Capteur.php';

use Dompdf\Dompdf;
use Dompdf\Options;

require_once __DIR__ . '/../vendor/autoload.php';

$dataTemp = Capteur::getLastTemperatureData(5);
$dataButane = Capteur::getLastButaneData(5);
$dataPresence = Capteur::getLastPresenceData(1);

function calcStats($array, $key) {
    if (empty($array)) return ['min' => '-', 'max' => '-', 'avg' => '-'];
    $values = array_column($array, $key);
    return [
        'min' => min($values),
        'max' => max($values),
        'avg' => round(array_sum($values) / count($values), 2)
    ];
}

$tempStats = calcStats($dataTemp, 'temp');
$butaneStats = calcStats($dataButane, 'value');
$presenceCount = $dataPresence[0]['personnes_count'] ?? '-';
$maxClasse = 18;

ob_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport - Salle connectée</title>
    <style>
        body { font-family: Helvetica, sans-serif; font-size: 14px; }
        h1, h2 { color: #2e8b57; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        table, th, td { border: 1px solid #999; }
        th, td { padding: 8px; text-align: center; }
        ul { list-style: none; padding-left: 0; }
    </style>
</head>
<body>

<h1>Rapport - Salle de classe connectée (Professeur)</h1>
<p>Export généré le <?= date('d/m/Y à H:i:s') ?></p>

<h2>🌡️ Température</h2>
<ul>
    <li>Moyenne : <?= $tempStats['avg'] ?> °C</li>
    <li>Min : <?= $tempStats['min'] ?> °C</li>
    <li>Max : <?= $tempStats['max'] ?> °C</li>
</ul>

<?php if (!empty($dataTemp)): ?>
<table>
    <thead><tr><th>Date</th><th>Température (°C)</th></tr></thead>
    <tbody>
    <?php foreach ($dataTemp as $row): ?>
        <tr><td><?= $row['date_time_temp'] ?></td><td><?= $row['temp'] ?></td></tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>Aucune donnée de température disponible.</p>
<?php endif; ?>

<h2>🟠 Butane</h2>
<ul>
    <li>Moyenne : <?= $butaneStats['avg'] ?> ppm</li>
    <li>Min : <?= $butaneStats['min'] ?> ppm</li>
    <li>Max : <?= $butaneStats['max'] ?> ppm</li>
</ul>

<?php if (!empty($dataButane)): ?>
<table>
    <thead><tr><th>Date</th><th>Taux Butane (ppm)</th></tr></thead>
    <tbody>
    <?php foreach ($dataButane as $row): ?>
        <tr><td><?= $row['timestamp'] ?></td><td><?= $row['value'] ?></td></tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>Aucune donnée de butane disponible.</p>
<?php endif; ?>

<h2>👥 Présence (Classe G4)</h2>
<p>Nombre d’élèves présents : <?= $presenceCount ?>/<?= $maxClasse ?></p>

</body>
</html>

<?php
$html = ob_get_clean();

file_put_contents(__DIR__ . "/debug_html_output.html", $html);

$options = new Options();
$options->set('defaultFont', 'Helvetica');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("rapport_professeur_volpe.pdf", ["Attachment" => true]);
