<?php
require_once __DIR__ . '/../config/db.php';

class AdminController {
    public static function createProf($email, $password) {
        global $privatePDO;

        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return "Email invalide.";

        $hashed = hash('sha256', $password);

        try {
            $stmt = $privatePDO->prepare("INSERT INTO users (email, password, role, is_active) VALUES (?, ?, 'prof', 1)");
            $stmt->execute([$email, $hashed]);
            return "Professeur créé avec succès.";
        } catch (PDOException $e) {
            return "Erreur BDD : " . $e->getMessage();
        }
    }

    public static function deleteUser($id) {
        global $privatePDO;

        try {
            $stmt = $privatePDO->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getAllProfs() {
        global $privatePDO;

        try {
            $stmt = $privatePDO->prepare("SELECT * FROM users WHERE role = 'prof'");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
