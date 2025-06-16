<?php
require_once __DIR__ . '/../config/db.php';

class Capteur {
    public static function getLastTemperatureData($limit = 10) {
        global $pdo; // ← obligatoire ici
        $stmt = $pdo->prepare("SELECT temp, date_time_temp FROM test_temperature2 ORDER BY date_time_temp DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getLastCO2Data($limit = 10) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT taux, date_time_taux FROM test_gaz ORDER BY date_time_taux DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getLastPresenceData($limit = 1) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT personnes_count, distance_cm, timestamp FROM proximity_sensor ORDER BY timestamp DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
