<?php 
namespace App\Models;

use App\Configs\Config;
use App\Services\ILoadStorage;
use PhpParser\Node\Expr\Cast\Bool_;

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

    public function saveData($arr): bool {
        return $this->dataStorage->saveData( $this->nameResource, $arr ); 
    }

    public function getBasketData(): array {
        if(!isset($_SESSION))
        {
        
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