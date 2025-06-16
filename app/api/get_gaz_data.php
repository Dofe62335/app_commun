<?php
$host = "app.garageisep.com";
$port = "5404";
$dbname = "app_db";
$user = "app_user";
$password = "appg4";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupère les 10 dernières entrées
    $stmt = $pdo->query("SELECT * FROM test_gaz ORDER BY date_time_taux DESC LIMIT 10");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
        $values = array_column($rows, 'taux');
        $min = min($values);
        $max = max($values);
        $avg = round(array_sum($values) / count($values), 2);

        echo "<table class='live-table'>";
        echo "<tr><th>Date</th><th>Taux CO₂</th></tr>";
        foreach ($rows as $row) {
            echo "<tr><td>{$row['date_time_taux']}</td><td>{$row['taux']}</td></tr>";
        }
        echo "</table>";
        echo "<p><strong>Min :</strong> $min | <strong>Max :</strong> $max | <strong>Moyenne :</strong> $avg</p>";
    } else {
        echo "Aucune donnée trouvée.";
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
