<?php 
namespace App\Controllers;

use App\Views\OrderTemplate;
use App\Models\Product;

class OrderController {
    public function get(): string {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST")
            return $this->create();

        $model = new Product();
        $data = $model->getBasketData();

        return OrderTemplate::getOrderTemplate($data);
    }

    public function create():string {
        $arr = [];
        $arr['fio'] =  $_POST['fio'];
        $arr['address'] = $_POST['address'];
        $arr['phone'] = $_POST['phone'];
        $arr['created_at'] = date("d-m-Y H:i:s");	// добавим дату и время создания заказа
    
        $model = new Product();
        // список заказанных продуктов - берем список товаров из корзины
        $products = $model->getBasketData();
        $arr['products'] = $products;
        // подсчитаем общую сумму заказа
        $all_sum = 0;
        foreach ($products as $product) {
            $all_sum += $product['price'] * $product['quantity'];
        }
        $arr['all_sum'] = $all_sum;
    
        // сохраняем данные
        $model->saveData($arr);
        
        // очистка корзины
        session_start();
        $_SESSION['basket'] = [];

        // сообщение для пользователя
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки";
        
        // переадресация на Главную
	    header("Location: /pizza221/");

        return "";
    }
}
