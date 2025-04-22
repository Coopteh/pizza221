<?php 
namespace App\Controllers;

use App\Views\RegisterTemplate;
use App\Models\User;
use App\Services\UserFactory;
use App\Services\ValidateRegisterData;
use App\Services\Mailer;
use App\Configs\Config;
use App\Services\UserDBStorage;

class RegisterController {
    public function get(): string {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST")
            return $this->create();

        return RegisterTemplate::getRegisterTemplate();
    }

    public function verify($token): string {
        if (!isset($token))
            $_SESSION['flash'] = "Ваш токен неверен";

        // Запись верификации (is_verified=1) для указанного токена
        if (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $serviceDB = new UserDBStorage();
            if ($serviceDB->saveVerified($token)) {
                return RegisterTemplate::getVerifyTemplate();
            } else {
                $_SESSION['flash'] = "Ваш токен ненайден";
            }
        }
        // переадресация на Главную
	    header("Location: /pizza221/");
        return "";
    }

    public function create():string {      
        $arr = [];
        $arr['username'] =  strip_tags($_POST['username']);
        $arr['email'] = strip_tags($_POST['email']);
        $arr['password'] = strip_tags($_POST['password']);
        $arr['confirm_password'] = strip_tags($_POST['confirm_password']);

        // Валидация (проверка) переданных из формы значений
        if (! ValidateRegisterData::validate($arr)) {
            // переадресация обратно на страницу регистрации
            header("Location: /pizza221/register");
            return "";
        }
        
        $hashed_password = password_hash($arr['password'], PASSWORD_DEFAULT );
        $verification_token = bin2hex(random_bytes(16));

        $arr['password'] = $hashed_password;
        $arr['token'] = $verification_token;
        // Создаем модель Product для работы с данными
        $model = UserFactory::createUser();
        // сохраняем данные
        $model->saveData($arr);

        Mailer::sendMailUserConfirmation(
            $arr['email'], 
            $verification_token,
            $arr['username']
        );
        // сообщение для пользователя
        $_SESSION['flash'] = "Спасибо за регистрацию! На ваш емайл отправлено письмо для подтверждения регистрации.";
        
        // переадресация на Главную
	    header("Location: /pizza221/");

        return "";
    }

}