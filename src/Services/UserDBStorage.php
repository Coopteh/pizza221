<?php
namespace App\Services;

use PDO;
use App\Configs\Config;

class UserDBStorage extends DBStorage implements ISaveStorage
{
    public function saveData($nameFile, $arr): bool
    {
        // Сохранение пользователя в таблице users
        $stmt = $this->connection->prepare("INSERT INTO " . Config::TABLE_USERS . " (fio, address, phone, email, all_sum) VALUES (:fio, :address, :phone, :email, :all_sum)");
        
        $stmt->bindParam(':fio', $arr['fio']);
        $stmt->bindParam(':address', $arr['address']);
        $stmt->bindParam(':phone', $arr['phone']);
        $stmt->bindParam(':email', $arr['email']);
        $stmt->bindParam(':all_sum', $arr['all_sum']);
        
        if (!$stmt->execute()) {
            throw new \Exception("Ошибка при сохранении пользователя: " . implode(", ", $stmt->errorInfo()));
        }
        
        // Получаем ID последней вставленной записи
        $userId = $this->connection->lastInsertId();
        
        return true;
    }

    public function loadData($nameFile): ?array
    {
        // Реализация загрузки данных (если необходимо)
        return null; // Заглушка
    }
}
