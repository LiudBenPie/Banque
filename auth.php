<?php
class Auth {
    protected $pdo;
    protected $sessionName = 'user';

    public function __construct($pdo) {
        $this->pdo = $pdo;

    }

    public function register($username, $password, $nom, $categorie = 'Agent') {
        $hashedPassword = md5($password); // Using md5 for hashing
        $stmt = $this->pdo->prepare("INSERT INTO employe (login, motDePasse, nom, categorie) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $hashedPassword, $nom, $categorie]);
    }

    public function login($username, $password) {
        $hashedPassword = md5($password); // Hash the password with md5 to compare
        $stmt = $this->pdo->prepare("SELECT * FROM employe WHERE login = ? AND motDePasse = ?");
        $stmt->execute([$username, $hashedPassword]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION[$this->sessionName] = $user['numEmploye'];
            return true;
        }

        return false;
    }

    public function logout() {
        unset($_SESSION[$this->sessionName]);
    }

    // Renamed and adjusted method to check for user role
    public function checkRole($requiredRole) {
        if (!isset($_SESSION[$this->sessionName])) {
            return false;
        }

        $userId = $_SESSION[$this->sessionName];
        $stmt = $this->pdo->prepare("SELECT categorie FROM employe WHERE numEmploye = ?");
        $stmt->execute([$userId]);
        $userCategorie = $stmt->fetchColumn();

        return $requiredRole == $userCategorie;
    }

    public function isLoggedIn() {
        return isset($_SESSION[$this->sessionName]);
    }
}
