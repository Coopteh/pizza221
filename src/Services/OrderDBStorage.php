<?php
namespace App\Services;

use PDO;
use PDOException;

class OrderDBStorage implements ISaveStorage
{
    private PDO $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                'mysql:host=localhost;dbname=is221;charset=utf8mb4',
                'root',
                '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            throw new \RuntimeException('Ошибка подключения к базе данных: ' . $e->getMessage());
        }
    }

    public function saveData(string $name, array $data): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO $name (product_id, quantity, price, created_at) 
                 VALUES (:product_id, :quantity, :price, NOW())"
            );
            
            return $stmt->execute([
                ':product_id' => $data['product_id'],
                ':quantity' => $data['quantity'],
                ':price' => $data['price']
            ]);
            
        } catch (PDOException $e) {
            error_log('Ошибка сохранения заказа: ' . $e->getMessage());
            return false;
        }
    }
}