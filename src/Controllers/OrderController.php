<?php

namespace App\Controllers;

use App\Models\Product;
use App\Views\OrderTemplate;

class OrderController {
    public function get(): string {
        // Проверяем HTTP-метод запроса
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            return $this->create();
        }

        // Если это GET-запрос, отображаем страницу заказа
        $productModel = new Product();
        $data = $productModel->getBasketData();

        $orderTemplate = new OrderTemplate();
        return $orderTemplate->getOrderTemplate($data);
    }
    public function create(): string {
       // Инициализируем массив для сохранения данных заказа
       $arr = [];
   
       // Получаем данные из POST-запроса
       $arr['fio'] = urldecode($_POST['fio']);
       $arr['address'] = urldecode($_POST['address']);
       $arr['phone'] = $_POST['phone'];
       $arr['created_at'] = date("d-m-Y H:i:s"); // Дата и время создания заказа
   
       // Получаем список товаров из корзины
       $model = new Product();
       $products = $model->getBasketData();
       $arr['products'] = $products;
   
       // Подсчитываем общую сумму заказа
       $all_sum = 0;
       foreach ($products as $product) {
           $all_sum += $product['price'] * $product['quantity'];
       }
       $arr['all_sum'] = $all_sum;

       // Сохраняем данные заказа через модель
       $model->saveData($arr);
   
       // Очищаем корзину
       session_start();
       $_SESSION['basket'] = [];
   
       // Добавляем флеш-сообщение об успешной операции
       $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки.";
   
       // Перенаправляем пользователя на главную страницу
       header("Location: /trenazherka/");
       return '';
   }
}