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
        session_start();
        
        $arr = [];
        $arr['fio'] =  $_POST['fio'];
        $arr['address'] = $_POST['address'];
        $arr['phone'] = $_POST['phone'];
        $arr['email'] = $_POST['email'];
        $arr['created_at'] = date("d-m-Y H:i:s");	// добавим дату и время создания заказа

        if (! $this->validate($arr)) {
            // переадресация обратно на страницу заказа
            header("Location: /pizza221/order");
            return "";
        }

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
        $_SESSION['basket'] = [];

        // сообщение для пользователя
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки";
        
        // переадресация на Главную
	    header("Location: /pizza221/");

        return "";
    }

    function validate(array $data): bool {
        // Проверка ФИО
        if (!isset($data['fio'])) {
            $_SESSION['flash'] = "Незаполнено поле ФИО.";
            return false;
        }
    
        // Проверка адреса
        if (!isset($data['address']) || 
            strlen(trim($data['address'])) < 10 || 
            strlen(trim($data['address'])) > 200) {
            $_SESSION['flash'] = "Поле адреса должно быть более 10 символов (но не более 200).";
            return false;
        }
    
        // Проверка телефона
        if (!isset($data['phone'])) {
            $_SESSION['flash'] = "Незаполнено поле Телефон.";
            return false;
        }
        $cleanedPhone = preg_replace('/[^\\d]/', '', $data['phone']);
        if (strlen($cleanedPhone) !== 11 || 
            !in_array($cleanedPhone[0], ['7', '8'])) {
            $_SESSION['flash'] = "Неверный номер телефона.";
            return false;
        }
    
        // Проверка email
        if (!isset($data['email']) || 
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash'] = "Неправильно заполнено поле Емайл.";
            return false;
        }
    
        return true;
    }
}