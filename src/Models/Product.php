<?php

namespace App\Models;

use App\Configs\Config;

class Product
{
    public function loadData(): ?array
    {
        $file = fopen(Config::FILE_PRODUCTS, 'r');
        if (!$file) {
            return null;
        }
        $data = fread($file, filesize(Config::FILE_PRODUCTS));
        fclose($file);
        return json_decode($data, true);
    }
    public function getBasketData(): array
    {
        session_start();
        
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }
        
        $products = $this->loadData(); // Загружаем данные товаров
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
