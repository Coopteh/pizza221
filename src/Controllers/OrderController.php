<?php

namespace App\Controllers;

use App\Models\Product;
use App\Views\OrderTemplate;

class OrderController {
    public function get(): string {
    // метод GET, POST, DELETE
    $method = $_SERVER['REQUEST_METHOD']; // Исправлено на правильное имя переменной
    if ($method == "POST") {
        return $this->create();
    }
        $productModel = new Product();
        $data = $productModel->getBasketData(); // Получаем данные корзины
        return OrderTemplate::getOrderTemplate($data); // Возвращаем шаблон
    }
    public function create() {
        $arr = [];
        $arr['fio'] = urldecode($_POST['fio']);
        $arr['address'] = urldecode($_POST['address']);
        $arr['phone'] = $_POST['phone'];
        $arr['created_at'] = date("d-m-Y H:i:s"); // добавим дату и время создания заказа
    
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
    
        // Сохраняем данные заказа
        $model->saveData($arr);
    
        // Очистка корзины
        session_start();
        $_SESSION['basket'] = [];
    
        // Уведомление об успешном создании заказа
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки";
    
        // Переадресация на главную страницу
        header("Location: /pizza221/");
        return '';
    }
}