<?php

namespace App\Models;

use App\Config\Config;

class Product {

    /**
     * Загружает данные о продуктах из JSON-файла.
     */
    public function loadData(): ?array {
        $file = fopen(Config::FILE_PRODUCTS, 'r');
        if (!$file) {
            return null;
        }

        $data = fread($file, filesize(Config::FILE_PRODUCTS));
        fclose($file);

        $arr = json_decode($data, true);
        return $arr;
    }

    /**
     * Возвращает данные о товарах в корзине.
     */
    public function getBasketData(): array {
        session_start();
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }

        $products = $this->loadData();
        $basketProducts = [];

        foreach ($products as $product) {
            $id = $product['id'];

            if (array_key_exists($id, $_SESSION['basket'])) {
                // Количество товара берем из корзины
                $quantity = $_SESSION['basket'][$id]['quantity'];

                // Остальные характеристики берем из массива всех товаров
                $name = $product['name'];
                $price = $product['price'];

                // Вычисляем сумму
                $sum = $price * $quantity;

                // Добавляем в новый массив
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

    /**
     * Сохраняет данные заказа в JSON-файл.
     */
    public function saveData($arr) {
        $nameFile= Config::FILE_ORDERS;

        $handle = fopen($nameFile, "r");
        if (filesize($nameFile) > 0){ 
            $data = fread($handle, filesize($nameFile)); 
            $allRecords = json_decode($data, true); 
        } else {
            $allRecords = [];
        }
        fclose($handle);
        
        $allRecords[]= $arr;
        $json = json_encode($allRecords, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $handle = fopen($nameFile, "w");
        fwrite($handle, $json);
        fclose($handle);
    }
}