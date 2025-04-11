<?php

namespace App\Controllers;

use App\Config\Config;
use App\Models\Order;
use App\Services\OrderDBStorage;
use App\Services\ProductDBStorage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Services\ValidateOrderData;
use App\Services\OrderFactory;
use App\Services\ProductFactory;
use App\Models\Product;
use App\Services\FileStorage;
use App\Views\OrderTemplate;

class OrderController {
    /**
     * Метод для обработки GET и POST запросов.
     */
    public function get(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            return $this->create();
        }

        // Создаем объект сервиса
        $model = ProductFactory::createProduct();
        $data = $model->getBasketData();

        $orderTemplate = new OrderTemplate();
        return $orderTemplate->getOrderTemplate($data);
    }

    /**
     * Метод для обработки данных формы заказа (POST-запрос).
     */
    public function create(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Создаем объект сервиса
        $model = ProductFactory::createProduct();
    
        // Валидация данных
        if (ValidateOrderData::validate($_POST)) {
            header("Location: /order");
            return "";
        }
    
        // Подготовка данных заказа
        $arr = [
            'fio' => urldecode($_POST['fio']),
            'address' => urldecode($_POST['address']),
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'payment_method' => $_POST['payment_method'],
            'created_at' => date("d-m-Y H:i:s"),
        ];
    
        // Получаем список товаров из корзины
        $products = $model->getBasketData();
        $arr['products'] = $products;
    
        // Подсчитываем общую сумму заказа
        $all_sum = 0;
        foreach ($products as $product) {
            $all_sum += $product['price'] * $product['quantity'];
        }
        $arr['all_sum'] = $all_sum;
    
        // Инициализация модели заказа
        $orderModel = OrderFactory::createOrder();
    
        // Сохраняем данные
        $orderModel->saveData($arr);

        // Очистка корзины
        if (isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }
    
        // Добавляем флеш-сообщение
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки.";
        header("Location: /pizza221/");
        return "";
    }

    /**
     * Метод для отправки письма.
     */
     public function sendMail($email): bool {
        if (empty($email)) {
            return false;
        }

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'ssl://smtp.mail.ru';
            $mail->SMTPAuth = true;
            $mail->Username = 'v.milevskiy@coopteh.ru'; // Лучше хранить в .env
            $mail->Password = 'qRbdMaYL6mfuiqcGX38z';  // Лучше хранить в .env
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('v.milevskiy@coopteh.ru', 'PIZZA-221');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Заявка с сайта: PIZZA-221';
            $mail->Body = "Информационное сообщение c сайта PIZZA-221 <br><br>
            ------------------------------------------<br><br>
            Спасибо!<br><br>
            Ваш заказ успешно создан и передан службе доставки.<br><br>
            Сообщение сгенерировано автоматически.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Ошибка отправки письма: " . $e->getMessage());
            return false;
        }
    }
}