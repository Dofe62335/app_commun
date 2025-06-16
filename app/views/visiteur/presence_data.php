<?php
require_once __DIR__ . '/../../models/Capteur.php';

header('Content-Type: application/json');

$data = Capteur::getLastPresenceData(1);
echo json_encode([
  'count' => $data[0]['personnes_count'] ?? 0
]);
