<?php
namespace App\Controllers;

use App\Services\UserDBStorage;
use App\Config\Config;

class BaseController {
    protected UserDBStorage $userStorage;

    public function __construct() {
        if (Config::STORAGE_TYPE === Config::TYPE_DB) {
            $this->userStorage = new UserDBStorage();
        }

        // Инициализация пользовательских данных
        $this->initUserData();
    }

    /**
     * Инициализация данных пользователя
     */
    protected function initUserData(): void {
        if (isset($_SESSION['user_id'])) {
            $userData = $this->userStorage->getUserById((int)$_SESSION['user_id']);
            global $user_id, $username, $avatar;

            $user_id = $_SESSION['user_id'];
            $username = $userData['username'] ?? '';
            $avatar = $userData['avatar'] ?? 'path/to/default/avatar.png'; // Дефолтный аватар
        } else {
            global $user_id, $username, $avatar;

            $user_id = 0;
            $username = '';
            $avatar = 'path/to/default/avatar.png';
        }
    }
}