<?php
require_once __DIR__ . '/../../models/Capteur.php';
$data = Capteur::getLastTemperatureData(10);
echo json_encode(array_map(function ($row) {
    return [
        'temp' => $row['temp'],
        'date' => date('H:i', strtotime($row['date_time_temp']))
    ];
}, $data));
