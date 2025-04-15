<?php 
namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Views\RegisterTemplate;
use App\Models\User; // Assuming you have a User model
use App\Services\UserDBStorage; // Assuming you have a UserDBStorage service
use App\Configs\Config;
use App\Services\UserFactory; // Assuming you have a UserFactory for creating users
use App\Services\ValidateUserData; // Assuming you have a ValidateUserData for validating user data


class RegisterController {
    public function get(): string {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST")
            return $this->create();

        return RegisterTemplate::getRegisterTemplate();
    }

    public function create(): string {
        session_start();
    
        $arr = [];
        $arr['fio'] = strip_tags($_POST['fio']);
        $arr['address'] = strip_tags($_POST['address']);
        $arr['phone'] = strip_tags($_POST['phone']);
        $arr['email'] = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']); // Получаем пароль из формы
        $arr['created_at'] = date("d-m-Y H:i:s"); // добавим дату и время создания пользователя
    
        // Валидация (проверка) переданных из формы значений
        if (!ValidateUserData::validate($arr)) {
            // переадресация обратно на страницу регистрации
            header("Location: /pizza221/register");
            return "";
        }
    
        // Хешируем пароль
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $verification_token = bin2hex(random_bytes(32)); // Генерация токена для подтверждения
    
        // Создаем массив данных для сохранения
        $arr['password'] = $hashed_password; // Добавляем хешированный пароль
        $arr['verification_token'] = $verification_token; // Добавляем токен подтверждения
    
        // Создаем модель User для работы с данными
        $userModel = UserFactory::createUser();
        
        // сохраняем данные
        $userModel->saveData($arr);
        
        // отправка емайл (вы можете добавить логику отправки подтверждения, если это необходимо)
        $this->sendMail($arr['email'], $verification_token);
    
        // сообщение для пользователя
        $_SESSION['flash'] = "Спасибо! Вы успешно зарегистрированы. Пожалуйста, проверьте вашу почту для подтверждения регистрации.";
        
        // переадресация на Главную
        header("Location: /pizza221/");
    
        return "";
    }
    
    public function sendMail($email): bool {
        $mail = new PHPMailer();
        if (isset($email) && !empty($email)) {
            try {
                $mail->SMTPDebug = 2;
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom("v.milevskiy@coopteh.ru", "PIZZA-221");
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'ssl://smtp.mail.ru';                   //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'v.milevskiy@coopteh.ru';                     //SMTP username
                $mail->Password   = 'qRbdMaYL6mfuiqcGX38z'; // Consider using environment variables for sensitive data
                $mail->Port       = 465;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Subject = 'Регистрация на сайте: PIZZA-221';
                $mail->Body = "Информационное сообщение с сайта PIZZA-221 <br><br>
                ------------------------------------------<br><br>
                Спасибо!<br><br>
                Вы успешно зарегистрированы.<br><br>
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
