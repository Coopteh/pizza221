<?php 
namespace App\Models;

use App\Services\ILoadStorage;

class Product {
    private ILoadStorage $dataStorage;
    private string $nameResource;
    
    public function __construct(ILoadStorage $service, string $name) {
        $this->dataStorage = $service;
        $this->nameResource = $name;
    }

    public function loadData(): ?array {
        return $this->dataStorage->loadData($this->nameResource); 
    }

    public function getBasketData(): array {
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }
        $products = $this->loadData();
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

    public function getAllSum(?array $products): float {
        $all_sum = 0;
        foreach ($products as $product) {
            $price = $product['price'];
            $quantity = $product['quantity'];
            $all_sum += $price * $quantity;
        }
        return $all_sum;
    }
}