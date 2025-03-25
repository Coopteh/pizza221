<?php 
namespace App\Controllers;

use App\Views\OrderTemplate;
use App\Models\Product;

class OrderController {
    public function get(): string {
        $model = new Product();
        $data = $model->getBasketData();
//var_dump($data);
//exit();
        return OrderTemplate::getOrderTemplate($data);
    }
}
