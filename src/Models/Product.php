<?php

namespace App\Models;

use App\Configs\Config;

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

    public function saveData(array $arr): void {
        // Формируем путь к файлу
        $nameFile = Config::FILE_ORDERS;

        // Читаем существующие данные из файла
        $handle = fopen($nameFile, "r");
        if (filesize($nameFile) > 0) { 
            $data = fread($handle, filesize($nameFile));
            $allRecords = json_decode($data, true); 
        } else {
            $allRecords = [];
        }
        fclose($handle);

        // Добавляем новый заказ в массив
        $allRecords[] = $arr;

        // Преобразуем массив в JSON и записываем обратно в файл
        $json = json_encode($allRecords, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $handle = fopen($nameFile, "w");
        fwrite($handle, $json);
        fclose($handle);
    }
}