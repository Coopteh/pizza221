<?php
namespace App\Controllers;
use App\Models\Product;
use App\Views\OrderTemplate;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class OrderController{
    public function get(): string{
        // метод GET, POST, DELETE
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST")
            return $this->create();
        $productModel = new Product();
        $data = $productModel -> getBasketData();
        $orderTemplate = new OrderTemplate();
        $result = $orderTemplate -> getOrderTemplate($data);
        return $result;
    }
    public function create() {
        session_start();
        $arr = [];
        $arr['fio'] = urldecode( $_POST['fio'] );
            $arr['address'] = urldecode( $_POST['address'] );
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

            $model->saveData($arr);

            $_SESSION['basket'] = [];
        
            $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки";
        
            header("Location: /pizza221/");
            return '';
    }
    function validate(array $data): bool {
        // Проверка ФИО
        if (!isset($data['fio'])) {
            $_SESSION['flash'] = "Не заполнено поле ФИО";
            return false;
        }
    
        // Проверка адреса
        if (!isset($data['address']) || 
            strlen(trim($data['address'])) < 10 || 
            strlen(trim($data['address'])) > 200) {
                $_SESSION['flash'] = "Поле адреса должно быть олее 10 символов, но не более 200";
            return false;
        }
    
        // Проверка телефона
        if (!isset($data['phone'])) {
            $_SESSION['flash'] = "Не правльно заполнен номер телефона";
            return false;
        }
        $cleanedPhone = preg_replace('/[^\\d]/', '', $data['phone']);
        if (strlen($cleanedPhone) !== 11 || 
            !in_array($cleanedPhone[0], ['7', '8'])) {
                $_SESSION['flash'] = "Не верный номер телефона";
            return false;
        }
    
        // Проверка email
        if (!isset($data['email']) || 
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash'] = "Не правильно заполнено поле имейл"; 
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
                // отправка емайл
                $this->sendMail($email);
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