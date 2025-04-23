<?php 
namespace App\Services;

use PDO;
use PDOException;

class UserDBStorage extends DBStorage implements ISaveStorage
{
    public function saveData(string $name, array $data): bool
    {
        try {
            $sql = "INSERT INTO `users` (`username`, `email`, `password`, `token`) 
                    VALUES (:name, :email, :pass, :token)";
            $sth = $this->connection->prepare($sql);
            return $sth->execute([
                'name' => $data['username'],
                'email' => $data['email'],
                'pass' => password_hash($data['password'], PASSWORD_DEFAULT), // Хешируем пароль
                'token' => $data['token']
            ]);
        } catch (PDOException $e) {
            // Логирование ошибки
            error_log('Ошибка сохранения данных пользователя: ' . $e->getMessage());
            return false;
        }
    }

    public function uniqueEmail(string $email): bool
    {
        try {
            $stmt = $this->connection->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->rowCount() === 0; // Если нет записей, email уникален
        } catch (PDOException $e) {
            error_log('Ошибка проверки уникальности email: ' . $e->getMessage());
            return false;
        }
    }

    public function saveVerified($token): bool
    {
        try {
            $this->connection->beginTransaction(); // Начинаем транзакцию

            $stmt = $this->connection->prepare("SELECT id FROM users WHERE token = ? AND is_verified = 0");
            $stmt->execute([$token]);

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch();
                $update = $this->connection->prepare("UPDATE users SET is_verified = 1, token = '' WHERE id = ?");
                $update->execute([$user['id']]);
                $this->connection->commit(); // Подтверждаем транзакцию
                return true;
            }

            $this->connection->rollBack(); // Откатываем транзакцию, если не нашли пользователя
            return false;
        } catch (PDOException $e) {
            $this->connection->rollBack(); // Откатываем транзакцию в случае ошибки
            error_log('Ошибка подтверждения пользователя: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Аутентификация пользователя
     */
    public function loginUser ($username, $password): bool
    {   
        try {
            $stmt = $this->connection->prepare("SELECT id, username, password FROM users 
                                                 WHERE is_verified = 1 AND (username = ? OR email = ?)");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();

            if ($user === false || !password_verify($password, $user['password'])) {
                return false; // Неверные учетные данные
            }
            
            // Установка переменных сессии
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        } catch (PDOException $e) {
            error_log('Ошибка аутентификации пользователя: ' . $e->getMessage());
            return false;
        }
    }
}