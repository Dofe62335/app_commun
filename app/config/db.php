<?php
// Connexion à la base privée locale (MySQL)
try {
    $privatePDO = new PDO('mysql:host=localhost;dbname=volpe_private;charset=utf8mb4', 'root', '');
    $privatePDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur BDD privée : " . $e->getMessage());
}

// Connexion à la base publique (PostgreSQL capteurs)
try {
    $pdo = new PDO("pgsql:host=app.garageisep.com;port=5404;dbname=app_db", 'app_user', 'appg4');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur BDD capteurs : " . $e->getMessage());
}
