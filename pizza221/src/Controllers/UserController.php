<?php
namespace App\Controllers;

use PDO;

class UserController {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function verify($token) {
        // Проверка наличия токена
        if (!isset($token)) {
            $message = "Токен подтверждения не предоставлен.";
            $this->renderVerificationPage($message);
            return;
        }

        // Проверка токена в базе данных
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE verification_token = ? AND is_verified = 0");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user) {
            // Обновление статуса пользователя
            $update = $this->pdo->prepare("UPDATE users SET is_verified = 1, verification_token = '' WHERE id = ?");
            $update->execute([$user['id']]);

            // Сообщение об успешном подтверждении
            $message = "Ваш email успешно подтвержден! Теперь вы можете войти.";
        } else {
            // Сообщение об ошибке подтверждения
            $message = "Неверный токен подтверждения или email уже подтвержден.";
        }

        // Отображение страницы с сообщением
        $this->renderVerificationPage($message);
    }

    private function renderVerificationPage($message) {
        echo "<h2>Подтверждение email</h2>";
        echo "<p>$message</p>";
        echo '<a href="login.php">Войти</a>';
    }
}