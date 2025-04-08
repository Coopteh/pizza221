<?php

namespace App\Services;

use PDO;

class OrderDBStorage extends DBStorage implements ISaveStorage
{
    public function saveData(string $name, array $data): bool
    {
        // Запрос для добавления заказа в таблицу orders
        $sql = "INSERT INTO `orders`
        (`fio`, `address`, `phone`, `email`, `all_sum`) 
        VALUES (:fio, :address, :phone, :email, :sum)";

        $sth = $this->connection->prepare($sql);

        $result = $sth->execute([
            'fio' => $data['fio'],
            'address' => $data['address'], // Исправляем на ключ 'address'
            'phone' => $data['phone'],    // Исправляем на ключ 'phone'
            'email' => $data['email'],    // Исправляем на ключ 'email'
            'sum' => $data['all_sum']     // Исправляем на ключ 'all_sum'
        ]);

        // Получаем идентификатор добавленного заказа
        $idOrder = $this->connection->lastInsertId();

        // Добавляем позиции заказа (заказанные товары)
        $this->saveItems($idOrder, $data['products']);

        return $result;
    }

    /**
     * Добавляет позиции заказа в таблицу order_item
     */
    public function saveItems(int $idOrder, array $products): bool
    {
        foreach ($products as $product) {
            $id = $product['id'];
            $price = $product['price'];
            $quantity = $product['quantity'];
            $sum = $price * $quantity;

            // SQL запрос на вставку данных в таблицу order_item
            $sql = "INSERT INTO `order_item`
            (`order_id`, `product_id`, `count_item`, 
            `price_item`, `sum_item`) 
            VALUES 
            (:id_order, :id_product, :count, :price, :sum)";

            $sth = $this->connection->prepare($sql);

            $sth->execute([
                'id_order' => $idOrder,      // Используем идентификатор заказа
                'id_product' => $id,         // Исправляем на ключ 'id'
                'count' => $quantity,        // Исправляем на ключ 'quantity'
                'price' => $price,           // Исправляем на ключ 'price'
                'sum' => $sum                // Считаем сумму как price * quantity
            ]);
        }
        return true;
    }
}