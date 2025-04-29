<?php 
namespace App\Controllers;

use App\Views\UserTemplate;
use App\Config\Config;
use App\Services\UserDBStorage;


class UserController {
    private UserDBStorage $userStorage;

    public function __construct() {
        if (Config::STORAGE_TYPE === Config::TYPE_DB) {
            $this->userStorage = new UserDBStorage();
        }
    }

    public function get(): string {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            return $this->login();
        }

        return UserTemplate::getUserTemplate();
    }

    private function login(): string {
        $username = strip_tags($_POST['username'] ?? '');
        $password = strip_tags($_POST['password'] ?? '');

        if (!$this->userStorage->loginUser($username, $password)) {
            $_SESSION['flash'] = "Ошибка ввода логина или пароля";
            return UserTemplate::getUserTemplate();
        }

        header("Location: /");
        exit();
    }

    public function profile(): string {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = "Необходимо войти в аккаунт.";
            header("Location: /login");
            exit();
        }

        $userData = $this->userStorage->getUserById((int)$_SESSION['user_id']);

        return UserTemplate::getProfileForm($userData);
    }

    public function updateProfile(): void {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = "Необходимо войти в аккаунт.";
            header("Location: /login");
            exit();
        }

        $userId = (int)$_SESSION['user_id'];
        $data = [
            'username' => strip_tags($_POST['username'] ?? ''),
            'email' => strip_tags($_POST['email'] ?? ''),
            'address' => strip_tags($_POST['address'] ?? ''),
            'phone' => strip_tags($_POST['phone'] ?? '')
        ];

        if (
            isset($_FILES['avatar']) &&
            $_FILES['avatar']['error'] === UPLOAD_ERR_OK &&
            is_uploaded_file($_FILES['avatar']['tmp_name'])
        ) {
            $fileTmpPath = $_FILES['avatar']['tmp_name'];
            $fileExtension = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = uniqid('avatar_', true) . '.' . $fileExtension;
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/uploads/';
                $destPath = $uploadDir . $newFileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $data['avatar'] = "/assets/uploads/" . $newFileName;
                } else {
                    $_SESSION['flash'] = "Ошибка при сохранении аватара.";
                }
            } else {
                $_SESSION['flash'] = "Недопустимый формат файла. Разрешены: jpg, png, gif, webp.";
            }
        }

        if ($this->userStorage->updateProfile($userId, $data)) {
            $_SESSION['flash'] = "Профиль успешно обновлен!";
        } else {
            $_SESSION['flash'] = "Ошибка при обновлении профиля.";
        }

        header("Location: /profile");
        exit();
    }
    public function getOrdersHistory(): string {
        global $user_id;

        $data = null;

        if (Config::STORAGE_TYPE === Config::TYPE_DB) {
            $serviceDB = new UserDBStorage();
            $data = $serviceDB->getDataHistory($user_id);
            if (!$data) {
                $_SESSION['flash'] = "Не удалось получить заказы.";
            }
        }

        return UserTemplate::getHistoryTemplate($data);
        
    }

}
