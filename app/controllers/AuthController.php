<?php
require_once __DIR__ . '/../config/db.php';

class AuthController {
    public static function login($email, $password) {
        global $privatePDO;

        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Email invalide.";
        }

        $stmt = $privatePDO->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && hash('sha256', $password) === $user['password']) {
            session_start();
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirection selon le rôle
            switch ($user['role']) {
                case 'admin':
                    header("Location: /volpe-site/app/views/admin/dashboard.php");
                    break;
                case 'prof':
                    header("Location: /volpe-site/app/views/prof/dashboard.php");
                    break;
                case 'visiteur':
                    header("Location: /volpe-site/app/views/visiteur/dashboard.php");
                    break;
                default:
                    return "Rôle non reconnu.";
            }
            exit;
        } else {
            return "Identifiants incorrects ou compte inactif.";
        }
    }

    public static function isAuthenticated($role = null) {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /volpe-site/app/views/auth/login.php");
            exit;
        }
        if ($role && $_SESSION['role'] !== $role) {
            header("Location: /volpe-site/app/views/auth/login.php");
            exit;
        }
    }

    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /volpe-site/app/views/auth/login.php");
        exit;
    }

    public static function register($email, $password) {
        global $privatePDO;

        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Email invalide.";
        }

        if (strlen($password) < 6) {
            return "Le mot de passe doit contenir au moins 6 caractères.";
        }

        $stmt = $privatePDO->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return "Un compte existe déjà avec cet email.";
        }

        $hashed = hash('sha256', $password);

        $stmt = $privatePDO->prepare("INSERT INTO users (email, password, role, is_active, created_at) VALUES (?, ?, 'visiteur', 1, NOW())");
        if ($stmt->execute([$email, $hashed])) {
            return "Inscription réussie. Vous pouvez vous connecter.";
        } else {
            return "Erreur lors de l'inscription.";
        }
    }
}
