<?php
require_once __DIR__ . '/../config/db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/SMTP.php';

class AuthController {
    // Connexion d'un utilisateur
    public static function login($email, $password) {
        global $privatePDO;

        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['code' => 0, 'message' => "Format d'email invalide."];
        }
        if (strlen($password) < 1) {
            return ['code' => 0, 'message' => "Le mot de passe ne peut pas être vide."];
        }

        $stmt = $privatePDO->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
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
            return ['code' => 0, 'message' => "Identifiants incorrects ou compte inactif."];
        }
    }

    // Vérifie si l'utilisateur est connecté, optionnellement avec un rôle spécifique
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

    // Déconnexion de l'utilisateur
    public static function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /volpe-site/app/views/auth/login.php");
        exit;
    }

    // Vérifie la force du mot de passe (Majuscule, minuscule, chiffre, ≥ 6 caractères)
    private static function passwordStrengthCheck($password) {
        if (strlen($password) < 6) return false;
        if (!preg_match('/[A-Z]/', $password)) return false;
        if (!preg_match('/[a-z]/', $password)) return false;
        if (!preg_match('/[0-9]/', $password)) return false;
        return true;
    }

    // Enregistre un compte VISITEUR uniquement
    public static function register($email, $password, $confirm_password, $terms) {
        global $privatePDO;

        if (!$terms) {
            return ['code' => 0, 'message' => "Veuillez accepter les conditions d'utilisation."];
        }

        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['code' => 0, 'message' => "Format d'email invalide."];
        }

        $stmt = $privatePDO->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return ['code' => 0, 'message' => "Cet email est déjà enregistré."];
        }

        if (!self::passwordStrengthCheck($password)) {
            return ['code' => 0, 'message' => "Le mot de passe doit contenir au moins une lettre majuscule, une minuscule et un chiffre."];
        }

        if ($password !== $confirm_password) {
            return ['code' => 0, 'message' => "Les deux mots de passe ne correspondent pas."];
        }

        $hashed = hash('sha256', $password);

        // Rôle fixé à 'visiteur'
        $stmt = $privatePDO->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, 'visiteur')");
        if ($stmt->execute([$email, $hashed])) {
            return ['code' => 1, 'message' => "Inscription réussie. Vous pouvez vous connecter."];
        } else {
            return ['code' => 0, 'message' => "Erreur lors de l'inscription."];
        }
    }

    
}
