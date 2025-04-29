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

        $result= $sth->execute( [
            'fio' => $data['fio'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'sum' => $data['all_sum']
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
            // SQL запрос на вставку данных в таблицу  order_item
            $sql = "INSERT INTO `order_item`
            (`order_id`, `product_id`, `count_item`, 
            `price_item`, `sum_item`) 
            VALUES 
            (:id_order, :id_product, :count, :price, :sum)";

            $sth = $this->connection->prepare($sql);

            $sth->execute( [
                'id_order' => $idOrder,
                'id_product' => $id,
                'count' => $quantity,
                'price' => $price,
                'sum' => $sum
            ] );
        }
        return true;
    }
}
