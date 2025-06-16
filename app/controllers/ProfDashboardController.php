<?php
require_once __DIR__ . '/../models/Capteur.php';

class ProfDashboardController {
    public static function getDashboardData() {
        $temperature = Capteur::getLastTemperatureData();
        $co2 = Capteur::getLastCO2Data();
        $presence = Capteur::getLastPresenceData();

        return [
            'temperature' => $temperature,
            'co2' => $co2,
            'presence' => $presence
        ];
    }
}
