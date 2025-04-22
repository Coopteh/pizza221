<?php 
namespace App\Controllers;

use App\Views\UserTemplate;
use App\Configs\Config;
use App\Services\UserDBStorage;

class UserController {
    public function get(): string {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST")
            return $this->login();

        return UserTemplate::getUserTemplate();
    }
    
    public function login():string {      

        $arr = [];
        $arr['username'] =  strip_tags($_POST['username']);
        $arr['password'] = strip_tags($_POST['password']);

        // проверка логина и пароля
        if (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $serviceDB = new UserDBStorage();
            if (!$serviceDB->loginUser($arr['username'], $arr['password'])) {
                $_SESSION['flash'] = "Ошибка ввода логина или пароля";
                return UserTemplate::getUserTemplate();
            }
        }

        // переадресация на Главную
	    header("Location: /pizza221/");
        return "";
    }
    public function logout() {
        session_start();
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        session_destroy();
        header("Location: /pizza221/");
        exit;
    }
    
}