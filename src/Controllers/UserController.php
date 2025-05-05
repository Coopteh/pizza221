<?php 
namespace App\Controllers;

use App\Views\UserTemplate;
use App\Configs\Config;
use App\Services\UserDBStorage;

class UserController {
    private $userStorage;

    public function __construct() {
        // Перенесено из глобальной области
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        error_log("Session user_id: " . ($_SESSION['user_id'] ?? 'not set'));
        error_log("Upload directory writable: " . (is_writable('D:/xampp/htdocs/avtoservis/assets/uploads/') ? 'yes' : 'no'));
        
        // Проверка прав на запись в директорию загрузок
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/avtoservis/assets/uploads/';
        if (!is_writable($uploadDir)) {
            error_log("Upload directory permissions: " . substr(sprintf('%o', fileperms($uploadDir)), -4));
            error_log("Owner: " . posix_getpwuid(fileowner($uploadDir))['name']);
        }

        if (Config::STORAGE_TYPE === Config::TYPE_DB) {
            $this->userStorage = new UserDBStorage();
        }
    }
    
    public function login(): string {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
    
        if ($this->userStorage->loginUser($username, $password)) {
            $user = $this->userStorage->getUserByUsername($username);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: /avtoservis/profile");
            exit;
        }
    
        $_SESSION['flash'] = "Неверный логин или пароль";
        return UserTemplate::getUserTemplate();
    }

    public function logout(): void {
        
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        session_destroy();
        header("Location: /avtoservis/");
        exit;
    }

    public function profile(): string {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /avtoservis/login");
            exit;
        }
    
        try {
            $user = $this->userStorage->getUserData($_SESSION['user_id']);
            
            $profileData = [
                'username' => $user['username'] ?? 'Не указано',
                'email' => $user['email'] ?? 'Не указано',
                'address' => $user['address'] ?? '',
                'phone' => $user['phone'] ?? '',
                'avatar' => $user['avatar'] ?? '/assets/images/default-avatar.png'
            ];
    
            return UserTemplate::getProfileForm($profileData);
        } catch (\RuntimeException $e) {
            $_SESSION['flash'] = "Ошибка загрузки профиля";
            header("Location: /avtoservis/");
            exit;
        }
    }

    public function updateProfile(): void {
        error_log("Files array: " . print_r($_FILES, true));
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] != UPLOAD_ERR_OK) {
            error_log("File upload error: " . ($_FILES['avatar']['error'] ?? 'No file uploaded'));
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("HTTP/1.1 405 Method Not Allowed");
            exit;
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: /avtoservis/login");
            exit;
        }

        $userId = (int)$_SESSION['user_id'];
        $data = [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'address' => $_POST['address'] ?? '',
            'phone' => $_POST['phone'] ?? ''
        ];

        // Обработка аватара с улучшенным логированием
        if (isset($_FILES['avatar'])) {
            error_log("Avatar upload data: " . print_r($_FILES['avatar'], true));
            
            if ($_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/avtoservis/assets/uploads/';
                
                // Создаем папку с проверкой прав
                if (!file_exists($uploadDir)) {
                    if (!mkdir($uploadDir, 0755, true)) {
                        error_log("Failed to create directory: " . $uploadDir);
                        $_SESSION['flash'] = "Ошибка создания папки для загрузки";
                        header("Location: /avtoservis/profile");
                        exit;
                    }
                }

                $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                if (in_array($ext, $allowed)) {
                    $filename = 'avatar_' . $userId . '_' . time() . '.' . $ext;
                    $destPath = $uploadDir . $filename;
                    
                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $destPath)) {
                        $data['avatar'] = '/avtoservis/assets/uploads/' . $filename;
                        error_log("Avatar successfully saved to: " . $destPath);
                    } else {
                        error_log("Move uploaded file failed. Check permissions for: " . $uploadDir);
                        $_SESSION['flash'] = "Ошибка сохранения файла. Пожалуйста, попробуйте другой файл.";
                    }
                } else {
                    $_SESSION['flash'] = "Недопустимый формат файла. Разрешены: " . implode(', ', $allowed);
                }
            } else {
                $_SESSION['flash'] = $this->getUploadError($_FILES['avatar']['error']);
            }
        }

        if ($this->userStorage->updateProfile($userId, $data)) {
            $_SESSION['flash'] = "Профиль успешно обновлен!";
            // Обновляем аватар в сессии
            if (isset($data['avatar'])) {
                $_SESSION['user_avatar'] = $data['avatar'];
            }
        } else {
            // Более информативное сообщение об ошибке
            $_SESSION['flash'] = "Изменения сохранены, но возникла небольшая техническая ошибка";
            error_log("Profile updated but database returned false");
        }
        
        header("Location: /avtoservis/profile");
        exit;
    }
    
    private function getUploadError(int $code): string {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'Файл слишком большой',
            UPLOAD_ERR_FORM_SIZE => 'Файл превышает размер формы',
            UPLOAD_ERR_PARTIAL => 'Файл загружен частично',
            UPLOAD_ERR_NO_FILE => 'Файл не выбран',
            UPLOAD_ERR_NO_TMP_DIR => 'Нет временной папки',
            UPLOAD_ERR_CANT_WRITE => 'Ошибка записи на диск',
            UPLOAD_ERR_EXTENSION => 'Расширение PHP остановило загрузку'
        ];
        return $errors[$code] ?? 'Неизвестная ошибка';
    }

    public function getOrdersHistory(): string {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /avtoservis/login");
            exit;
        }

        $data = $this->userStorage->getDataHistory($_SESSION['user_id']);
        return UserTemplate::getHistoryTemplate($data);
    }
    public function showLoginForm(): string {
        return UserTemplate::getUserTemplate();
    }
    public function handleLoginRequest(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->login();
        }
        return $this->showLoginForm();
    }
}