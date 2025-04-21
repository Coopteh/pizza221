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
use App\Services\OrderFactory;
use App\Services\ProductFactory;
use App\Services\ValidateOrderData;
use App\Services\Mailer;

class OrderController {
    public function get(): string {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            return $this->create();
        }
    
        // Инициализация переменной $model
        $model = null;
    
        $model = ProductFactory::createProduct();
    
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

        if (! ValidateOrderData::validate($arr)) {
            // переадресация обратно на страницу заказа
            header("Location: /pizza221/order");
            return "";
        }
        // список заказанных продуктов - берем список товаров из корзины
        $model = ProductFactory::createProduct();

        $products = $model->getBasketData();
        $arr['products'] = $products;
        
        // подсчитаем общую сумму заказа
        $all_sum = 0;
        foreach ($products as $product) {
            $all_sum += $product['price'] * $product['quantity'];
        }
        $arr['all_sum'] = $all_sum;
        
        //Сохраняем данные заказа
        $orderModel = OrderFactory::createOrder();    

        // сохраняем данные
        $orderModel->saveData($arr);
    
        // отправка емайл
        $this->sendMail($arr['email']);
        
        // Очищаем корзину
        $_SESSION['basket'] = [];
        
        // Добавляем флеш-сообщение об успешной операции
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки.";
        
        // Перенаправляем пользователя на главную страницу
        header("Location: /strax/order");
        return '';
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
