<?php
namespace App\Services;

use PDO;
use App\Configs\Config;

class OrderDBStorage extends DBStorage implements ISaveStorage
{
    public function saveData($nameFile, $arr): bool
    {
        // Сохранение заказа в таблице orders
        $stmt = $this->connection->prepare("INSERT INTO " . Config::TABLE_ORDERS . " (fio, address, phone, email, all_sum) VALUES (:fio, :address, :phone, :email, :all_sum)");
        
        $stmt->bindParam(':fio', $arr['fio']);
        $stmt->bindParam(':address', $arr['address']);
        $stmt->bindParam(':phone', $arr['phone']);
        $stmt->bindParam(':email', $arr['email']);
        $stmt->bindParam(':all_sum', $arr['all_sum']);
        
        if (!$stmt->execute()) {
            throw new \Exception("Ошибка при сохранении заказа: " . implode(", ", $stmt->errorInfo()));
        }
        
        // Получаем ID последней вставленной записи
        $orderId = $this->connection->lastInsertId();
        
        // Сохраняем позиции заказа
        $this->saveItems($orderId, $arr['products']);
        
        return true;
    }

    public function saveItems($orderId, $products): void
    {
        $stmt = $this->connection->prepare("INSERT INTO order_item (order_id, product_id, count_item, price_item, sum_item) VALUES (:order_id, :product_id, :count_item, :price_item, :sum_item)");

        foreach ($products as $product) {
            $productId = $product['id']; // Предполагается, что в массиве есть id продукта
            $quantity = $product['quantity'];
            $price = $product['price'];
            $sum = $price * $quantity;

            $stmt->bindParam(':order_id', $orderId);
            $stmt->bindParam(':product_id', $productId);
            $stmt->bindParam(':count_item', $quantity);
            $stmt->bindParam(':price_item', $price);
            $stmt->bindParam(':sum_item', $sum);

            if (!$stmt->execute()) {
                throw new \Exception("Ошибка при сохранении позиции заказа: " . implode(", ", $stmt->errorInfo()));
            }
        }
    }

    public function loadData($nameFile): ?array
    {
        // Реализация загрузки данных (если необходимо)
        return null; // Заглушка
    }
}