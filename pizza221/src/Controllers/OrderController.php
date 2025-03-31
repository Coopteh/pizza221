<?php

namespace App\Controllers;

use App\Models\Product;
use App\Views\OrderTemplate;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
        session_start();
        $arr = [];
        $arr['fio'] = urldecode($_POST['fio']);
        $arr['address'] = urldecode($_POST['address']);
        $arr['phone'] = $_POST['phone'];
        $arr['email'] = urldecode($_POST['email']); // Добавлено поле email
        $arr['created_at'] = date("d-m-Y H:i:s"); // добавим дату и время создания заказа

        // Валидация данных
        if (!$this->validate($arr)) {
            // Переадресация обратно на страницу заказа с сообщением об ошибке
            header("Location: /pizza221/order");
            return '';
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

        // Сохраняем данные заказа
        $model->saveData($arr);

         // Отправка подтверждающего письма
    if ($this->sendMail($arr['email'])) {
        // Уведомление об успешном создании заказа
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки. Подтверждение отправлено на ваш email.";
    } else {
        // Уведомление об ошибке отправки письма
        $_SESSION['flash'] = "Ваш заказ успешно создан, но произошла ошибка при отправке подтверждения на email.";
    }
        // Очистка корзины
       
        $_SESSION['basket'] = [];

        // Уведомление об успешном создании заказа
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки";

        // Переадресация на главную страницу
        header("Location: /pizza221/");
        return '';
    }

    private function validate(array $data): bool {
        // Проверка ФИО
        if (!isset($data['fio']) || preg_match('/\d/', $data['fio'])) {
            $_SESSION['flash'] = "ФИО содержит недопустимые символы. Исправьте, пожалуйста.";
            return false;
        }

        // Проверка адреса
        if (!isset($data['address']) || 
            strlen(trim($data['address'])) < 10 || 
            strlen(trim($data['address'])) > 200) {
            $_SESSION['flash'] = "Ошибка при проверке адреса, исправьте, пожалуйста.";
            return false;
        }

        // Проверка телефона
        if (!isset($data['phone'])) {
            $_SESSION['flash'] = "Ошибка при проверке телефона, исправьте, пожалуйста.";
            return false;
        }
        $cleanedPhone = preg_replace('/[^\d]/', '', $data['phone']);
        if (strlen($cleanedPhone) !== 11 || 
            !in_array($cleanedPhone[0], ['7', '8'])) {
            $_SESSION['flash'] = "Ошибка при проверке телефона, исправьте, пожалуйста.";
            return false;
        }

        // Проверка email
        if (!isset($data['email']) || 
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash'] = "Ошибка при проверке email, исправьте, пожалуйста.";
            return false;
        }

        return true;
    }
    public function sendMail($email) {
        $mail = new PHPMailer();
        if (isset($email) && !empty($email)) {
            try {
                $mail->SMTPDebug = 2;
                $mail->CharSet = 'UTF-8';
                $mail->setFrom("v.milevskiy@coopteh.ru", "PIZZA-221");
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->isSMTP();
                $mail->Host       = 'ssl://smtp.mail.ru';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'v.milevskiy@coopteh.ru';
                $mail->Password   = 'qRbdMaYL6mfuiqcGX38z';
                $mail->Port       = 465;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Subject = 'Заявка с сайта: PIZZA-221';
                $mail->Body = "Информационное сообщение c сайта PIZZA-221 <br><br>
                ------------------------------------------<br><br>
                Спасибо!<br><br>
                Ваш заказ успешно создан и передан службе доставки.<br><br>
                Сообщение сгенерировано автоматически.";
                if ($mail->send()) {
                    return true;
                } else {
                    throw new Exception('Ошибка с отправкой письма');
                }
            } catch (Exception $error) {
                $message = $error->getMessage();
            }
        }
        return false;
    }
}