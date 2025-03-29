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
        $arr['email'] = $_POST['email']; // Добавляем email
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

        // Проверка валидности данных
        if (!$this->validate($arr)) {
            header("Location: /trenazherka/order");
            exit;
        }

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

    protected function validate(array $data): bool {
        // Проверка ФИО
        if (!isset($data['fio']) || preg_match('/\d/', $data['fio'])) {
            $_SESSION['flash'] = "ФИО содержит недопустимые символы. Исправьте, пожалуйста.";
            return false;
        }

        // Проверка адреса
        if (!isset($data['address']) || strlen(trim($data['address'])) < 10 || strlen(trim($data['address'])) > 200) {
            $_SESSION['flash'] = "Адрес указан неверно. Пожалуйста, уточните адрес доставки.";
            return false;
        }

        // Проверка телефона
        if (!isset($data['phone'])) {
            $_SESSION['flash'] = "Телефон не указан. Укажите, пожалуйста, ваш контактный номер.";
            return false;
        }
        
        $cleanedPhone = preg_replace('/[^0-9]/', '', $data['phone']); // Очистка номера от лишних символов
        if (strlen($cleanedPhone) != 11 || !in_array(substr($cleanedPhone, 0, 1), ['7', '8'])) {
            $_SESSION['flash'] = "Номер телефона введен неправильно. Проверьте правильность ввода.";
            return false;
        }

        // Проверка e-mail
        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash'] = "E-mail указан неверно. Проверьте правильность указанного e-mail.";
            return false;
        }

        return true;
    }
}