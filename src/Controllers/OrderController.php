<?php

namespace App\Controllers;

use App\Configs\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Product;
use App\Views\OrderTemplate;
use App\Services\FileStorage;
use App\Services\OrderDBStorage;
use App\Services\ProductDBStorage;
use App\Models\Order;

class OrderController {
    public function get(): string {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            return $this->create();
        }
    
        // Инициализация переменной $model
        $model = null;
    
        if (Config::STORAGE_TYPE == Config::TYPE_FILE) {
            $serviceStorage = new FileStorage();
            $model = new Product($serviceStorage, Config::FILE_PRODUCTS);
        } elseif (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $serviceStorage = new ProductDBStorage();
            $model = new Product($serviceStorage, Config::TABLE_PRODUCTS);
        }
    
        // Проверка, была ли инициализирована переменная $model
        if ($model === null) {
            // Обработка случая, когда модель не была инициализирована
            throw new \Exception("Модель не инициализирована. Проверьте настройки хранения данных.");
        }
    
        $data = $model->getBasketData();
    
        return OrderTemplate::getOrderTemplate($data);
    }

    public function create(): string {
        session_start();
        $arr = [];
        $arr['fio'] =  strip_tags($_POST['fio']);
        $arr['address'] = strip_tags($_POST['address']);
        $arr['phone'] = strip_tags($_POST['phone']);
        $arr['email'] = strip_tags($_POST['email']);
        $arr['created_at'] = date("d-m-Y H:i:s");	// добавим дату и время создания заказа

        if (! $this->validate($arr)) {
            // переадресация обратно на страницу заказа
            header("Location: /pizza221/order");
            return "";
        }
        // список заказанных продуктов - берем список товаров из корзины
        if (Config::STORAGE_TYPE == Config::TYPE_FILE) {
            $serviceStorage = new FileStorage();
            $model = new Product($serviceStorage, Config::FILE_PRODUCTS);
        }
        if (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $serviceStorage = new ProductDBStorage();
            $model = new Product($serviceStorage, Config::TABLE_PRODUCTS);
        }

        $products = $model->getBasketData();
        $arr['products'] = $products;
        
        // подсчитаем общую сумму заказа
        $all_sum = 0;
        foreach ($products as $product) {
            $all_sum += $product['price'] * $product['quantity'];
        }
        $arr['all_sum'] = $all_sum;
        
        //Сохраняем данные заказа
        if (Config::STORAGE_TYPE == Config::TYPE_FILE) {
            $serviceStorage = new FileStorage();
            $orderModel = new Order($serviceStorage, Config::FILE_ORDERS);
        }
        if (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $serviceStorage = new OrderDBStorage();
            $orderModel = new Order($serviceStorage, Config::TABLE_ORDERS);
        }     
        // сохраняем данные
        $orderModel->saveData($arr);
    
        // отправка емайл
        $this->sendMail($arr['email']);
        
        // Очищаем корзину
        $_SESSION['basket'] = [];
        
        // Добавляем флеш-сообщение об успешной операции
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки.";
        
        // Перенаправляем пользователя на главную страницу
        header("Location: /pizza221/order");
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
    public function sendMail($email) {
        $mail = new PHPMailer();
        if (isset($email) && !empty($email)) {
            try {
                $mail->SMTPDebug = 2;
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom("v.milevskiy@coopteh.ru", "Obyvnoi_magazin");
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->isSMTP();
                $mail->Host       = 'ssl://smtp.mail.ru';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'v.milevskiy@coopteh.ru';
                $mail->Password   = 'qRbdMaYL6mfuiqcGX38z';
                $mail->Port       = 465;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Subject = 'Заявка с сайта: Obyvnoi_magazin';
                $mail->Body = "Информационное сообщение c сайта Obyvnoi_magazin <br><br>
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
var_dump($message);
exit();
            }
        }
        return false;
    }
}