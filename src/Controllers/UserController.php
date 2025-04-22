<?php 
namespace App\Controllers;

use App\Views\UserTemplate;
use App\Config\Config;
use App\Services\UserDBStorage;

class UserController {
    private $userStorage;

    public function __construct() {
        // Инициализация хранилища пользователей
        if (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $this->userStorage = new UserDBStorage();
        }
    }

    /**
     * Метод для обработки запросов к странице входа
     */
    public function get(): string {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            return $this->login();
        }

        return UserTemplate::getUserTemplate();
    }

    /**
     * Метод для аутентификации пользователя
     */
    public function login(): string {      
        $arr = [];
        $arr['username'] = strip_tags($_POST['username']);
        $arr['password'] = strip_tags($_POST['password']);

        // Проверка логина и пароля
        if (!$this->userStorage->loginUser($arr['username'], $arr['password'])) {
            $_SESSION['flash'] = "Ошибка ввода логина или пароля";
            return UserTemplate::getUserTemplate();
        }

        // Переадресация на Главную
        header("Location: /");
        return "";
    }

    /**
     * Метод для отображения страницы профиля
     */
    public function profile(): string {
      
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = "Необходимо войти в аккаунт.";
            header("Location: /login");
            exit();
        }

        // Получение данных пользователя
        $userId = $_SESSION['user_id'];
        $userData = $this->userStorage->getUserById($userId);

        // Отображение формы профиля
        return UserTemplate::getProfileForm($userData);
    }

    /**
     * Метод для обновления данных профиля
     */
    public function updateProfile(): void {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = "Необходимо войти в аккаунт.";
            header("Location: /login");
            exit();
        }

        // Получение данных из POST-запроса
        $userId = $_SESSION['user_id'];
        $data = [
            'username' => strip_tags($_POST['username']),
            'email' => strip_tags($_POST['email']),
            'address' => strip_tags($_POST['address'] ?? ''),
            'phone' => strip_tags($_POST['phone'] ?? ''),
        ];

        // Обновление данных в базе данных
        if ($this->userStorage->updateProfile($userId, $data)) {
            $_SESSION['flash'] = "Профиль успешно обновлен!";
        } else {
            $_SESSION['flash'] = "Ошибка при обновлении профиля.";
        }

        // Переадресация обратно на страницу профиля
        header("Location: /profile");
        exit();
    }
}