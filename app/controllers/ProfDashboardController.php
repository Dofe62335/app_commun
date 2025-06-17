<?php
require_once __DIR__ . '/../models/Capteur.php';

class ProfDashboardController {
    public static function getDashboardData() {
        $temperature = Capteur::getLastTemperatureData();
        $butane = Capteur::getLastButaneData();
        $presence = Capteur::getLastPresenceData();
        $buzzers = Capteur::getActiveBuzzers(); 

        return [
            'temperature' => $temperature,
            'butane' => $butane,
            'presence' => $presence,
            'buzzers' => $buzzers 
        ];
    }
}
