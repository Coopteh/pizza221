<?php 
namespace App\Models;

use App\Configs\Config;

class Product {
    const FILE_ORDERS = "./storage/order.json";

    public function saveData($arr) {
        if ($arr === null) {
            throw new \InvalidArgumentException('Trying to save null data');
        }

        $json = json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        if ($json === false) {
            throw new \JsonException('Error while encoding data to json');
        }

        $handle = fopen(self::FILE_ORDERS, "a");
        if ($handle === false) {
            throw new \RuntimeException('Error while opening file for writing');
        }
        fwrite($handle, $json . PHP_EOL); // добавляем новую строку для каждого заказа
        fclose($handle);
    }
    public function loadData(): ?array {
        $nameFile = Config::FILE_PRODUCTS;

        if (!file_exists($nameFile)) {
            throw new \RuntimeException('File not found: ' . $nameFile);
        }

        $handle = fopen($nameFile, "r");
        if ($handle === false) {
            throw new \RuntimeException('Error while opening file for reading');
        }

        $filesize = filesize($nameFile);
        if ($filesize === 0) {
            fclose($handle);
            return null; // or return an empty array if preferred
        }

        $data = fread($handle, $filesize);
        fclose($handle);

        if ($data === false) {
            throw new \RuntimeException('Error while reading the file');
        }

        $arr = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \JsonException('Error while decoding JSON: ' . json_last_error_msg());
        }

        return $arr;
    }

    public function getBasketData(): array {
        if(!isset($_SESSION))
        {
            session_start();
        }

        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }
        $products = $this->loadData();
        $basketProducts= [];
//var_dump($_SESSION['basket']);
        foreach ($products as $product) {
            $id = $product['id'];

            if (array_key_exists($id, $_SESSION['basket'])) {
                // количество товара берем то что указано в корзине
                $quantity = $_SESSION['basket'][$id]['quantity'];

                // остальные характеристики берем из массива всех товаров
                $name = $product['name'];
                $price= $product['price'];

                // сумму вычислим 
                $sum  = $price * $quantity;

                // добавим в новый массив
                $basketProducts[] = array( 
                    'id' => $id, 
                    'name' => $name, 
                    'quantity' => $quantity,
                    'price' => $price,
                    'sum' => $sum,
                );
            }
        }

        return $basketProducts;
    }
}