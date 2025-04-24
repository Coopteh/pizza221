<?php 
namespace App\Models;

use App\Services\ILoadStorage;

class Product {
    private ILoadStorage $dataStorage;
    private string $nameResource;
    
    // Внедряем зависимость через конструктор
    public function __construct(ILoadStorage $service, string $name)
    {
        $this->dataStorage = $service;
        $this->nameResource = $name;
    }

    public function loadData(): ?array {
        return $this->dataStorage->loadData( $this->nameResource ); 
    }

    public function getBasketData(): array {
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

        /* 
        Подсчет общей суммы заказа (товаров в корзине)
    */
    public function getAllSum(?array $products): float {
        $all_sum =0;
        foreach ($products as $product) {
            $price = $product['price'];
		    $quantity = $product['quantity'];

            $all_sum += $price * $quantity;
	    }
        return $all_sum;
    }
}