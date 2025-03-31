<?php

namespace App\Controllers;

use App\Config\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
        $storageService = new FileStorage();
        $productModel = new Product($storageService, 'products_data');

        // Получаем данные корзины
        $data = $productModel->getBasketData();

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
        $storageService = new FileStorage();
        if (Config::STORAGE_TYPE == Config::TYPE_FILE) {
            $serviceStorage = new FileStorage();
            $model = new Product($serviceStorage, Config::FILE_PRODUCTS);
        }

        // Валидация данных
        if (!$this->validate($_POST)) {
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

        if (Config::STORAGE_TYPE == Config::TYPE_FILE) {
            $serviceStorage = new FileStorage();
            $model = new Product($serviceStorage, Config::FILE_ORDERS);
        }        

        // Сохраняем данные заказа
        if ($model->saveData($arr)) {
            $this->sendMail($arr['email']);
            $_SESSION['basket'] = [];
        } else {
            $_SESSION['flash'] = "Ошибка при сохранении заказа. Попробуйте снова.";
            header("Location: /order");
            return "";
        }

        // Добавляем флеш-сообщение
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки.";
        header("Location: /pizza221/");
        return "";
    }

    /**
     * Метод для валидации данных формы заказа.
     */
    private function validate(array $data): bool {
        // Валидация адреса
        if (!isset($data['address']) || strlen(trim($data['address'])) < 10 || strlen(trim($data['address'])) > 200) {
            $_SESSION['flash'] = "Ошибка при проверке адреса. Адрес должен быть от 10 до 200 символов.";
            $_SESSION['form_data'] = $data;
            return false;
        }

        // Валидация телефона
        if (!isset($data['phone'])) {
            $_SESSION['flash'] = "Ошибка при проверке телефона. Телефон не может быть пустым.";
            $_SESSION['form_data'] = $data;
            return false;
        }
        $cleanedPhone = preg_replace('/[^0-9]/', '', $data['phone']);
        if (strlen($cleanedPhone) !== 11 || !in_array($cleanedPhone[0], ['7', '8'])) {
            $_SESSION['flash'] = "Ошибка при проверке телефона. Убедитесь, что номер состоит из 11 цифр и начинается с 7 или 8.";
            $_SESSION['form_data'] = $data;
            return false;
        }

        // Валидация email
        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash'] = "Ошибка при проверке email. Убедитесь, что email введен в правильном формате.";
            $_SESSION['form_data'] = $data;
            return false;
        }

        return true;
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