<?php

namespace App\Services;

use PDO;

class OrderDBStorage extends DatabaseStorage implements IStorage
{
    public function saveData($nameFile, $arr): bool
    {
        // Предполагаем, что $arr содержит данные заказа, например:
        // $arr = ['customer_id' => 1, 'total_amount' => 100.00, 'status' => 'pending'];

        // SQL-запрос для вставки новой записи в таблицу order
        $sql = "INSERT INTO orders (customer_id, total_amount, status) VALUES (:customer_id, :total_amount, :status)";
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':customer_id', $arr['customer_id']);
            $stmt->bindParam(':total_amount', $arr['total_amount']);
            $stmt->bindParam(':status', $arr['status']);
            
            // Выполняем запрос
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error saving order: " . $e->getMessage();
            return false; // Возвращаем false в случае ошибки
        }
    }

    public function saveItems($products): bool
    {
        // SQL-запрос для вставки данных в таблицу order_item
        $sql = "INSERT INTO order_item (order_id, product_name, price, quantity, sum) VALUES (:order_id, :product_name, :price, :quantity, :sum)";
        
        try {
            foreach ($products as $product) {
                // Предполагаем, что у вас есть переменная $orderId с ID созданного заказа
                // Например: $orderId = 1; (это нужно получить после выполнения saveData)

                // Вычисляем сумму для позиции заказа
                $name = $product['name'];
                $price = $product['price'];
                $quantity = $product['quantity'];
                $sum = $price * $quantity;

                // Подготовка и выполнение запроса для каждой позиции
                $stmt = $this->connection->prepare($sql);
                // Здесь предполагается наличие переменной с ID заказа
                // Замените на актуальный ID заказа после его создания
                $stmt->bindParam(':order_id', /* ваш ID заказа */);
                $stmt->bindParam(':product_name', $name);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->bindParam(':sum', $sum);

                if (!$stmt->execute()) {
                    return false; // Если не удалось сохранить хотя бы одну позицию, возвращаем false
                }
            }
            return true; // Все позиции успешно сохранены
        } catch (PDOException $e) {
            echo "Error saving order items: " . $e->getMessage();
            return false; // Возвращаем false в случае ошибки
        }
    }
}