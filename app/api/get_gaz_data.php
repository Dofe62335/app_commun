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
    $stmt = $pdo->query("SELECT * FROM capt_butane ORDER BY timestamp DESC LIMIT 10");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
        $values = array_column($rows, 'value');
        $min = min($values);
        $max = max($values);
        $avg = round(array_sum($values) / count($values), 2);

        echo "<table class='live-table'>";
        echo "<tr><th>Date</th><th>Taux Butane (ppm)</th></tr>";
        foreach ($rows as $row) {
            echo "<tr><td>{$row['timestamp']}</td><td>{$row['value']}</td></tr>";
        }
        echo "</table>";
        echo "<p><strong>Min :</strong> $min ppm | <strong>Max :</strong> $max ppm | <strong>Moyenne :</strong> $avg ppm</p>";
    } else {
        echo "Aucune donnée trouvée.";
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
