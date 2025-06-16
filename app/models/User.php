echo "User.php chargé ✅<br>";

<?php
require_once __DIR__ . '/../config/db.php';

class User {
    public static function findByEmail($email) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($email, $password, $role = 'prof') {
        global $pdo;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (email, password_hash, role) VALUES (?, ?, ?)");
        return $stmt->execute([$email, $hash, $role]);
    }

    public static function getAllProfs() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM users WHERE role = 'prof'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteById($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
