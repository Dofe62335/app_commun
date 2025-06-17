<?php
require_once __DIR__ . '/../models/Capteur.php';

class VisiteurDashboardController {
    public static function getDashboardData() {
        $temperature = Capteur::getLastTemperatureData(10); // pour graphique
        $lastTemp = Capteur::getLastTemperatureData(1);     // pour affichage en gros
        $presence = Capteur::getLastPresenceData(1);        // compteur
        $buzzers = Capteur::getActiveBuzzers();             // buzzers

        return [
            'temperature' => $temperature,
            'lastTemp' => $lastTemp[0]['temp'] ?? null,
            'presence' => $presence[0]['personnes_count'] ?? 0,
            'buzzers' => $buzzers
        ];
    }
}
