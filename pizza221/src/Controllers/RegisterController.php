<?php 
namespace App\Controllers;

use App\Views\RegisterTemplate;
use App\Models\User;
use App\Services\UserFactory;

class RegisterController {
    public function get(): string {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST")
            return $this->create();

        return RegisterTemplate::getRegisterTemplate();
    }

    public function create():string {      
        $arr = [];
        $arr['username'] =  strip_tags($_POST['username']);
        $arr['email'] = strip_tags($_POST['email']);
        $arr['password'] = strip_tags($_POST['password']);
        $arr['confirm_password'] = strip_tags($_POST['confirm_password']);

        $hashed_password = password_hash($arr['password'], PASSWORD_DEFAULT);
        $verification_token = bin2hex(random_bytes(16));

        $arr['password'] = $hashed_password;
        $arr['token'] = $verification_token;
        // Создаем модель Product для работы с данными
        $model = UserFactory::createUser();
        // сохраняем данные
        $model->saveData($arr);
        // сообщение для пользователя
        session_start();
        $_SESSION['flash'] = "Спасибо за регистрацию! На ваш емайл отправлено письмо для подтверждения регистрации.";
        
        // переадресация на Главную
	    header("Location: /pizza221/");

        return "";
    }

}
