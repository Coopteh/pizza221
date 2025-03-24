<?php

namespace App\Models;

use App\Config\Config;

class Product
{
    public function loadData(): ?array {
        // Открываем файл в режиме чтения
        if ($file = fopen(Config::FILE_PRODUCTS, 'r')) {
            // Считываем всё содержимое файла в переменную $data
            $data = fread($file, filesize(Config::FILE_PRODUCTS));
            // Закрываем файл
            fclose($file);
            
            // Декодируем строку JSON в ассоциативный массив
            $arr = json_decode($data, true);

            // Возвращаем полученный массив
            return $arr;
        }
        
        // Если открыть файл не удалось, возвращаем null
        return null;
    }

public function getBasketData(): ?array {
    session_start();
    if (!isset($_SESSION['basket'])) {
        $_SESSION['basket'] = [];
    }
    $products = $this->loadData(); // Предполагается, что этот метод загружает все товары
    $basketProducts = [];

    foreach ($products as $product) {
        $id = $product['id'];

        if (array_key_exists($id, $_SESSION['basket'])) {
            $quantity = $_SESSION['basket'][$id]['quantity'];
            $name = $product['name'];
            $price = $product['price'];
            $sum = $price * $quantity;

            $basketProducts[] = [
                'id' => $id,
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price,
                'sum' => $sum,
            ];
        }
    }
    return $basketProducts;
}
}