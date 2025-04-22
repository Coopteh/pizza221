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
//var_dump($username);
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
}