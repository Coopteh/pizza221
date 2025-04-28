<?php 
namespace App\Controllers;

use App\Views\UserTemplate;
use App\Configs\Config;
use App\Services\UserDBStorage;

class UserController {
    /* Форма входа на сайт */
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

    /* Форма профиля пользователя */
    public function profile(): string {
        global $user_id;

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST")
            return $this->updateProfile($data);
        
        $data = null;
        // проверка логина и пароля
        if (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $serviceDB = new UserDBStorage();
            $data = $serviceDB->getUserData($user_id);
            if (! $data) {
                $_SESSION['flash'] = "Ошибка получения данных пользователя";
            }
        }
        return UserTemplate::getProfileTemplate($data);
    }

    public function updateProfile(): string {
        $arr = [];
        $arr['address'] = strip_tags($_POST['address']);
        $arr['phone'] = strip_tags($_POST['phone']);

        // сохранение в БД
        if (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $serviceDB = new UserDBStorage();
            if (!$serviceDB->updateProfile($arr)) {
                $_SESSION['flash'] = "Ошибка сохранения данных";
            }
        }

        $_SESSION['flash'] = "Данные профиля обновлены";
        // переадресация на Главную
	    header("Location: /pizza221/");
        return "";
    }
}