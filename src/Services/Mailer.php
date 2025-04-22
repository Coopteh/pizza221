<?php 
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Config\Config;

class Mailer {
    //  временный емайл с https://tempail.com

    public static function sendOrderMail($email):bool {
        $mail = new PHPMailer();
        if (isset($email) && !empty($email)) {
            try {
                $mail->SMTPDebug = 0;
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

    // Отправка email с подтверждением
    public static function sendMailUserConfirmation(
        string $email, 
        string $verification_token,
        string $username
    ): bool 
    {
        $mail = new PHPMailer();
        if (isset($email) && !empty($email)) {
            try {
                $mail->SMTPDebug = 0; // Отключаем отладочный вывод
                $mail->CharSet = 'UTF-8';
                $mail->SetFrom("v.milevskiy@coopteh.ru", "PIZZA-221");
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->isSMTP();
                $mail->Host       = 'ssl://smtp.mail.ru';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'v.milevskiy@coopteh.ru';
                $mail->Password   = 'qRbdMaYL6mfuiqcGX38z';
                $mail->Port       = 465;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    
                $verification_link = Config::SITE_URL . "/verify/" . $verification_token;
    
                $mail->Subject = "Подтверждение регистрации с сайта: PIZZA-221";
    
                $mail->Body = "
                    <!DOCTYPE html>
                    <html lang='ru'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Подтверждение регистрации</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f9f9f9;
                                margin: 0;
                                padding: 0;
                            }
                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                background-color: #ffffff;
                                border-radius: 8px;
                                overflow: hidden;
                                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                            }
                            .header {
                                background-color: rgb(208,157,176);
                                color: #ffffff;
                                text-align: center;
                                padding: 20px;
                            }
                            .content {
                                padding: 20px;
                                text-align: center;
                                color: #333333;
                            }
                            .button {
                                display: inline-block;
                                margin-top: 20px;
                                padding: 12px 24px;
                                background-color: rgb(208,157,176);
                                color: #ffffff;
                                text-decoration: none;
                                border-radius: 4px;
                                font-size: 16px;
                                font-weight: bold;
                            }
                            .footer {
                                text-align: center;
                                padding: 10px;
                                font-size: 12px;
                                color: #999999;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h1>Добро пожаловать в PIZZA-221!</h1>
                            </div>
                            <div class='content'>
                                <p>Здравствуйте, $username!</p>
                                <p>Спасибо за регистрацию на нашем сайте. Пожалуйста, подтвердите ваш email, нажав на кнопку ниже:</p>
                                <a href='$verification_link' class='button'>Подтвердить Email</a>
                                <p>Если кнопка не работает, скопируйте и вставьте следующую ссылку в браузер:</p>
                                <p><a href='$verification_link'>$verification_link</a></p>
                            </div>
                            <div class='footer'>
                                <p>Это автоматическое сообщение. Пожалуйста, не отвечайте на него.</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";
    
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