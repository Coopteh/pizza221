<?php 
namespace App\Services;

use PDO;

class UserDBStorage extends DBStorage implements ISaveStorage
{
    public function saveData(string $name, array $data): bool
    {
        $sql = "INSERT INTO `users`
        (`username`, `email`, `password`, `token`) 
        VALUES (:name, :email, :pass, :token)";

        $sth = $this->connection->prepare($sql);

        $result= $sth->execute( [
            'name' => $data['username'],
            'email' => $data['email'],
            'pass' => $data['password'],
            'token' => $data['token']
        ] );

        return $result;
    }

    public function uniqueEmail(string $email): bool
    {
        $stmt = $this->connection->prepare(
            "SELECT id FROM users WHERE email = ?"
        );
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) 
            return false;
        return true;
    }

    public function saveVerified($token): bool
    {
        $stmt = $this->connection->prepare(
            "SELECT id FROM users WHERE token = ? 
            AND is_verified = 0");
        $stmt->execute([$token]);

        if ($stmt->rowCount() > 0) {

            $user = $stmt->fetch();
            $update = $this->connection->prepare(
                "UPDATE users SET is_verified = 1, 
                token = '' 
                WHERE id = ?");
            $update->execute([$user['id']]);

            return true;
        }
        return false;
    }

    /**
     * Аутентификация пользователя
     */
    public function loginUser($username, $password):bool {   

        // Поиск пользователя
        $stmt = $this->connection->prepare(
            "SELECT id, username, password FROM users 
            WHERE is_verified = 1 and
            (username = ? OR email = ?)");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
var_dump($user);
//var_dump($password);
//exit();
        // проверка записи
        if ($user === false) 
            return false;
        if (!password_verify($password, $user['password']))
            return false;
        
        // Установка переменных сессии
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        return true;
    }
    /**
     * Получение данных пользователя по ID
     */
    public function getUserById(int $userId): array
    {
        $stmt = $this->connection->prepare(
            "SELECT id, username, email, address, phone, avatar FROM users WHERE id = ?"
        );
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Обновление данных профиля пользователя (с учётом аватара)
     */
    public function updateProfile(int $userId, array $data): bool
    {
        $fields = [
            'username = :username',
            'email = :email',
            'address = :address',
            'phone = :phone'
        ];
        if (!empty($data['avatar'])) {
            $fields[] = 'avatar = :avatar';
        }

        $query = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->connection->prepare($query);

        $params = [
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':address' => $data['address'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':id' => $userId
        ];

        if (!empty($data['avatar'])) {
            $params[':avatar'] = $data['avatar'];
        }

        return $stmt->execute($params);
    }
    public function getDataHistory(): array {
        if (!isset($_SESSION['user_id'])) {
            return []; // Если пользователь не авторизован, возвращаем пустой массив
        }

        $userId = $_SESSION['user_id'];
        $stmt = $this->connection->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Возвращаем массив всех заказов
    }
}