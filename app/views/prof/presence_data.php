<?php
require_once __DIR__ . '/../../models/Capteur.php';

$data = Capteur::getLastPresenceData(1);
echo json_encode([
    'latest' => $data[0]['personnes_count'] ?? 0
]);
