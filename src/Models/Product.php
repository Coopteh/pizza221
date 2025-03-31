<?php

namespace App\Models;

use App\Configs\Config;
use Exception;
use App\Services\IStorage;
use PhpParser\Node\Expr\Cast\Bool_;

class Product
{    private IStorage $dataStorage;
    private string $nameResource;
    
    // Внедряем зависимость через конструктор
    public function __construct(IStorage $service, string $name)
    {
        $this->dataStorage = $service;
        $this->nameResource = $name;
    }

    public function loadData(): ?array {
        return $this->dataStorage->loadData( $this->nameResource ); 
    }

    public function saveData($arr): bool {
        return $this->dataStorage->saveData( $this->nameResource, $arr ); 
    }

    public function getBasketData(): ?array {
        session_start();
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }
        $products = $this->loadData(); // Загружаем все товары
        $basketProducts = [];

        foreach ($products as $product) {
            if (isset($product['id'])){
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
        }
        return $basketProducts;
    }

}

