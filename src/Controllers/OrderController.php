<?php 
namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Views\OrderTemplate;
use App\Models\Product;
use App\Models\Order;
use App\Services\FileStorage;
use App\Services\ProductDBStorage;
use App\Services\OrderDBStorage;
use App\Configs\Config;
use App\Services\ProductFactory;
use App\Services\OrderFactory;
use App\Services\ValidateOrderData;

class OrderController {
    public function get(): string {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST")
            return $this->create();

        $model = ProductFactory::createProduct();
        $data = $model->getBasketData();
        $all_sum = $model->getAllSum($data);
        
        return OrderTemplate::getOrderTemplate($data, $all_sum);
    }

    public function create():string {
        session_start();
        
        $arr = [];
        $arr['fio'] =  strip_tags($_POST['fio']);
        $arr['address'] = strip_tags($_POST['address']);
        $arr['phone'] = strip_tags($_POST['phone']);
        $arr['email'] = strip_tags($_POST['email']);
        $arr['created_at'] = date("d-m-Y H:i:s");	// добавим дату и время создания заказа

        // Валидация (проверка) переданных из формы значений
        if (! ValidateOrderData::validate($arr)) {
            // переадресация обратно на страницу заказа
            header("Location: /pizza221/order");
            return "";
        }

        // Создаем модель Product для работы с данными
        $model = ProductFactory::createProduct();

        // список заказанных продуктов - берем список товаров из корзины
        $products = $model->getBasketData();
        $arr['products'] = $products;
        // подсчитаем общую сумму заказа
        $all_sum = 0;
        foreach ($products as $product) {
            $all_sum += $product['price'] * $product['quantity'];
        }
        $arr['all_sum'] = $all_sum;
    
        $orderModel = OrderFactory::createOrder();
        // сохраняем данные
        $orderModel->saveData($arr);
        
        // отправка емайл
        $this->sendMail( $arr['email'] );

        // очистка корзины
        $_SESSION['basket'] = [];

        // сообщение для пользователя
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки";
        
        // переадресация на Главную
	    header("Location: /pizza221/");

        return "";
    }

    public function sendMail($email):bool {
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
                var_dump($message);
                exit();
            }
        }
        return false;
    }
}
