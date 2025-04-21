<?php  

namespace Src\Controllers;
use PDO;

class UserController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function verify() {
        if (!isset($_GET['token'])) {
            echo "Токен подтверждения не предоставлен.";
            return;
        }

        $token = $_GET['token'];
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE verification_token = ? AND is_verified = 0");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user) {
            $update = $this->pdo->prepare("UPDATE users SET is_verified = 1, verification_token = '' WHERE id = ?");
            $update->execute([$user['id']]);
            echo "Ваш email успешно подтвержден! Теперь вы можете войти.";
        } else {
            echo "Неверный токен подтверждения или email уже подтвержден.";
        }
    }
}