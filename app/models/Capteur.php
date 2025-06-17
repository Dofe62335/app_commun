<?php
require_once __DIR__ . '/../config/db.php';

class Capteur {
    public static function getLastTemperatureData($limit = 10) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT temp, date_time_temp FROM test_temperature ORDER BY date_time_temp DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getLastButaneData($limit = 10) { // ← nouveau
        global $pdo;
        $stmt = $pdo->prepare("SELECT value, timestamp, alert FROM capt_butane ORDER BY timestamp DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getLastPresenceData($limit = 1) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT personnes_count, distance_cm, timestamp FROM proximity_sensor ORDER BY timestamp DESC LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getActiveBuzzers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM buzzer WHERE flagactivation = true ORDER BY id_alerte ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
