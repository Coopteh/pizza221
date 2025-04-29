<?php

namespace App\Services;

use PDO;

class OrderDBStorage extends DBStorage implements ISaveStorage
{
    public function saveData(string $name, array $data): bool
    {
        global $user_id;
        $sql = "INSERT INTO `orders`
        (`fio`, `addres`, `phone`, `email`, `all_sum`, `payment_method`, `user_id`, `status`) 
        VALUES (:fio, :addres, :phone, :email, :sum, :payment_method, :idUser, 1 )";

        $sth = $this->connection->prepare($sql);

        $result= $sth->execute( [
            'fio' => $data['fio'],
            'addres' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'sum' => $data['all_sum'],
            'payment_method' => $data['payment_method'],
            'idUser' => $user_id,
        ] );

        // получаем идентификатор добавленного заказа
        $idOrder = $this->connection->lastInsertId();
        // добавляем позиции заказа (заказанные товары)
        $this->saveItems($idOrder, $data['products']);

        return $result;
    }

    /*
    добавляет позиции заказа в таблицу order_item
    */
    public function saveItems(int $idOrder, array $products): bool 
{
    foreach ($products as $product) {
        $id = $product['id'];
        $price = $product['price'];
        $quantity = $product['quantity'];
        $sum = $price * $quantity;

        // Обрати внимание на исправление: УБРАНА ЗАПЯТАЯ ПОСЛЕ `sum_item`
        $sql = "INSERT INTO `order_item`
                (`order_id`, `product_id`, `count_item`, `price_item`, `sum_item`) 
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
