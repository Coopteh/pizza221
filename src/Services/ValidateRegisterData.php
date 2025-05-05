<?php 
namespace App\Services;

use App\Configs\Config;
use App\Services\UserDBStorage;

class ValidateRegisterData {
    public static function validate(array $data): bool {
        // Проверка ФИО
        if ((!isset($data['username'])) || empty($data['username']) ) {
            $_SESSION['flash'] = "Имя пользователя обязательно";
            return false;
        }
    
        // Проверка email
        if (!isset($data['email']) || empty($data['email'])) {
            $_SESSION['flash'] = "Email обязателен";
            return false;
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash'] = "Некорректный email";
            return false;
        }
    
        // Пароль
        if (!isset($data['password']) || empty($data['password'])) {
            $_SESSION['flash'] = "Пароль обязателен";
            return false;
        }
        // Проверка на длину пароля
        if (strlen($data['password']) < 6) {
            $_SESSION['flash'] = "Пароль должен быть не менее 6 символов";
            return false;
        }
        // проверка - совпадают ли пароли
        if ($data['password'] !== $data['confirm_password']) {
            $_SESSION['flash'] = "Пароли не совпадают";
            return false;
        }

        // Проверка на уникальность емайл
        if (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $serviceDB = new UserDBStorage();
            if (!$serviceDB->uniqueEmail($data['email'] )) {
                $_SESSION['flash'] = "Указанный email уже зарегистрирован";
                return false;
            }
        }
        return true;
    }
}