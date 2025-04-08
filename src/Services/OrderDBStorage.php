<?php

namespace App\Services;

use PDO;

class OrderDBStorage extends DBStorage implements ISaveStorage
{
    public function saveData(string $name, array $data): bool
    {
        $sql = "INSERT INTO `orders`
        (`fio`, `address`, `phone`, `email`, `all_sum`) 
        VALUES (:fio, :address, :phone, :email, :sum)";

        $sth = $this->connection->prepare($sql);

        $result = $sth->execute([
            'fio' => $data['fio'],
            'address' => $data['address'], // заполнение адреса
            'phone' => $data['phone'],     // заполнение телефона
            'email' => $data['email'],     // заполнение email
            'sum' => $data['all_sum']      // сумма всего заказа
        ]);

        // Получаем идентификатор добавленного заказа
        $idOrder = $this->connection->lastInsertId();
        
        // Добавляем позиции заказа (товары)
        $this->saveItems($idOrder, $data['products']);

        return $result;
    }

    /**
     * Сохраняет позиции заказа в таблицу order_item
     *
     * @param int   $idOrder Идентификатор заказа
     * @param array $products Массив товаров
     *
     * @return bool
     */
    public function saveItems(int $idOrder, array $products): bool
    {
        foreach ($products as $product) {
            $id = $product['id'];           // id товара
            $price = $product['price'];     // цена товара
            $quantity = $product['quantity'];// количество
            $sum = $price * $quantity;      // общая стоимость позиции

            // SQL-запрос для вставки данных в таблицу order_item
            $sql = "INSERT INTO `order_item`
                    (`order_id`, `product_id`, `count_item`, 
                     `price_item`, `sum_item`)
                    VALUES 
                    (:id_order, :id_product, :count, :price, :sum)";

            $sth = $this->connection->prepare($sql);

            $sth->execute([
                'id_order' => $idOrder,
                'id_product' => $id,
                'count' => $quantity,
                'price' => $price,
                'sum' => $sum
            ]);
        }

        return true;
    }
}