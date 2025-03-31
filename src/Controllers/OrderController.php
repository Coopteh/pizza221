<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Models\Product;
use App\Views\OrderTemplate;

class OrderController {
    /**
     * Метод для обработки GET и POST запросов.
     */
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

    /**
     * Метод для обработки данных формы заказа (POST-запрос).
     */
    public function create(): string {
        // Валидация данных
        if (!$this->validate($_POST)) {
            // Перенаправляем пользователя обратно на страницу заказа
            header("Location: /order");
            return "";
        }

        // Инициализируем массив для сохранения данных заказа
        $arr = [];
    
        // Получаем данные из POST-запроса
        $arr['fio'] = urldecode($_POST['fio']);
        $arr['address'] = urldecode($_POST['address']);
        $arr['phone'] = $_POST['phone'];
        $arr['email'] = $_POST['email'];
        $arr['payment_method'] = $_POST['payment_method']; // Добавляем способ оплаты
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
        $this->sendMail($arr ['email']);
    
        // Очищаем корзину
        session_start();
        $_SESSION['basket'] = [];
    
        // Добавляем флеш-сообщение об успешной операции
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки.";
    
        // Перенаправляем пользователя на главную страницу
        header("Location: /pizza221/");
        return '';
    }

    /**
     * Метод для валидации данных формы заказа.
     */
    private function validate(array $data): bool {
        session_start();
    
    
        // Проверка адреса
        if (!isset($data['address']) || strlen(trim($data['address'])) < 10 || strlen(trim($data['address'])) > 200) {
            $_SESSION['flash'] = "Ошибка при проверке адреса. Адрес должен быть от 10 до 200 символов.";
            $_SESSION['form_data'] = $data; // Сохраняем данные формы
            return false;
        }
    
        // Проверка телефона
        if (!isset($data['phone'])) {
            $_SESSION['flash'] = "Ошибка при проверке телефона. Телефон не может быть пустым.";
            $_SESSION['form_data'] = $data; // Сохраняем данные формы
            return false;
        }
        $cleanedPhone = preg_replace('/[^0-9]/', '', $data['phone']);
        if (strlen($cleanedPhone) !== 11 || !in_array($cleanedPhone[0], ['7', '8'])) {
            $_SESSION['flash'] = "Ошибка при проверке телефона. Убедитесь, что номер состоит из 11 цифр и начинается с 7 или 8.";
            $_SESSION['form_data'] = $data; // Сохраняем данные формы
            return false;
        }
    
        // Проверка email
        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash'] = "Ошибка при проверке email. Убедитесь, что email введен в правильном формате.";
            $_SESSION['form_data'] = $data; // Сохраняем данные формы
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
                $mail->SetFrom("v.milevskiy@coopteh.ru","PIZZA-221");
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'ssl://smtp.mail.ru';                   //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'v.milevskiy@coopteh.ru';                     //SMTP username
                $mail->Password   = 'qRbdMaYL6mfuiqcGX38z';
                $mail->Port       = 465;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
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