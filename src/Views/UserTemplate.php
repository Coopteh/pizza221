<?php 
namespace App\Views;

use App\Views\BaseTemplate;
use App\Configs\Config;

class UserTemplate extends BaseTemplate
{
    /*
        Формирование страница "Регистрация"
    */
    public static function getUserTemplate(): string {
        $template = parent::getTemplate();
        $title= 'Вход пользователя';
        $content = <<<CORUSEL
        <main class="row p-5 justify-content-center align-items-center">
            <div class="col-5 bg-light border">
                <h3 class="mb-5">Вход пользователя</h3>
        CORUSEL;
        $content .= self::getFormLogin();
        $content .= "</div></main>";

        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }

    /* 
        Форма входа (логин, пароль)
    */
    public static function getFormLogin(): string {
        return <<<HTML
            <form action="/avtoservis/login" method="POST">
                <div class="mb-3">
                    <label for="nameInput" class="form-label">Логин (имя или емайл):</label>
                    <input type="text" name="username" class="form-control" id="nameInput" required>
                </div>
                <div class="mb-3">
                    <label for="passwordInput" class="form-label">Пароль:</label>
                    <input type="password" name="password" class="form-control" id="passwordInput" required>
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        HTML;
    }

    public static function getHistoryTemplate(?array $data): string {
        $template = parent::getTemplate();
        $title = 'История заказов';
        $content = <<<HTML
        <main class="row p-5 justify-content-center align-items-center">
            <div class="col-8 bg-light border">
                <h3 class="mb-5">История заказов</h3>
        HTML;
    
        $content .= <<<TABLE
            <table class="table table-striped">
            <tr>    
                <th>Номер заказа</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Статус</th>
            </tr>
        TABLE;
    
        foreach($data as $row) {
            $orderDate = date("d-m-Y H:i", strtotime($row['created']));
            $nameStatus = Config::getStatusName($row['status']);
            $colorStyle = Config::getStatusColor($row['status']); // Предполагается, что вы добавили этот метод
            $content .= <<<TABLE
            <tr>    
                <td>Заказ #{$row['id']}</td>
                <td>{$orderDate}</td>
                <td>{$row['all_sum']} ₽</td>
                <td class="{$colorStyle}">{$nameStatus}</td>
            </tr>
            TABLE;
        }
        
        $content .= '</table>';
        $content .= "</div></main>";
    
        return sprintf($template, $title, $content);
    }

    public static function getProfileForm(array $userData = []): string {
        $template = parent::getTemplate();
        $title = 'Редактирование профиля';
    
        $username = htmlspecialchars($userData['username'] ?? '');
        $email = htmlspecialchars($userData['email'] ?? '');
        $address = htmlspecialchars($userData['address'] ?? '');
        $phone = htmlspecialchars($userData['phone'] ?? '');
        $avatar = htmlspecialchars($userData['avatar'] ?? '/assets/images/default-avatar.png');
        
        $content = <<<HTML
        <style>
            .custom-input-group {
                position: relative;
                display: flex;
                align-items: center;
                border: 2px solid rgb(161, 157, 208);
                border-radius: 8px;
                overflow: hidden;
                transition: border-color 0.3s ease;
            }
    
            .custom-input-group:focus-within {
                border-color: rgb(161, 157, 208);
            }
    
            .custom-input-group .input-group-text {
                padding: 0.75rem 1rem;
                background-color: transparent;
                border: none;
                color: rgb(161, 157, 208);
            }
    
            .custom-input-group .form-control {
                flex: 1;
                border: none;
                box-shadow: none;
                outline: none;
                padding: 0.75rem 1rem;
                font-size: 1rem;
                color: #333;
            }
    
            .custom-input-group .form-control::placeholder {
                color: #aaa;
            }
    
            .btn-custom {
                background-color: rgb(161, 157, 208);
                color: #fff;
                font-weight: bold;
                transition: all 0.3s ease;
            }
    
            .btn-custom:hover {
                background-color: rgb(161, 157, 208);
            }
    
            .avatar-wrapper {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin-bottom: 2rem;
            }
    
            .avatar-preview-form {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                margin-bottom: 1rem;
                transition: transform 0.3s ease;
            }
    
            .avatar-preview-form:hover {
                transform: scale(1.05);
            }
    
            .upload-btn {
                font-size: 0.9rem;
                padding: 0.4rem 1rem;
                border-radius: 20px;
                background-color: rgb(161, 157, 208);
                color: white;
                border: none;
                transition: all 0.3s ease;
                cursor: pointer;
            }
    
            .upload-btn:hover {
                background-color: rgb(161, 157, 208);
            }
    
            input[type="file"] {
                display: none;
            }
            
            .custom-input-group {
                display: flex;
                align-items: center;
                border: 3px solid rgb(161, 157, 208);
                border-radius: 10px;
                overflow: hidden;
                transition: border-color 0.3s ease;
                width: 100%;
                height: 56px;
            }
    
            .custom-input-group:focus-within {
                border-color: rgb(161, 157, 208);
            }
    
            .custom-input-group .input-group-text {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0 1rem;
                background-color: transparent;
                color: rgb(161, 157, 208);
                border-right: 3px solid rgb(161, 157, 208);
                height: 100%;
                line-height: 1;
            }
    
            .custom-input-group .form-control {
                border: none;
                outline: none;
                box-shadow: none;
                padding: 0 1rem;
                font-size: 1rem;
                flex: 1;
                color: #333;
                height: 100%;
                line-height: 1.5;
                margin: 0;
            }
        </style>
        <main class="row p-4 justify-content-center align-items-start">
            <div class="col-lg-6 col-md-8 bg-white border rounded shadow p-4">
                <h3 class="text-center mb-4" style="color: rgb(161, 157, 208);">Редактирование профиля</h3>
    
                <form action="/avtoservis/profile/update" method="POST" enctype="multipart/form-data" method="POST">
                    <!-- Аватар -->
                    <div class="avatar-wrapper">
                        <img src="{$avatar}" alt="Аватар пользователя" class="avatar-preview-form">
                        <label class="upload-btn">
                            <i class="fas fa-camera me-2"></i> Загрузить новый
                            <input type="file" name="avatar" accept="image/*">
                        </label>
                    </div>
    
                    <!-- Имя пользователя -->
                    <div class="input-group mb-3 custom-input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user-edit"></i>
                        </span>
                        <input type="text" name="username" class="form-control" value="{$username}" placeholder="Имя пользователя" required>
                    </div>
    
                    <!-- Email -->
                    <div class="input-group mb-3 custom-input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control" value="{$email}" placeholder="Email" required>
                    </div>
    
                    <!-- Адрес -->
                    <div class="input-group mb-3 custom-input-group">
                        <span class="input-group-text">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        <input type="text" name="address" class="form-control" value="{$address}" placeholder="Адрес">
                    </div>
    
                    <!-- Телефон -->
                    <div class="input-group mb-3 custom-input-group">
                        <span class="input-group-text">
                            <i class="fas fa-phone"></i>
                        </span>
                        <input type="text" name="phone" class="form-control" value="{$phone}" placeholder="Телефон">
                    </div>
    
                    <!-- Кнопка -->
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-custom">  
                            <i class="fas fa-save me-2"></i> Сохранить изменения
                        </button>
                    </div>
                </form>
                
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const avatarInput = document.querySelector('input[name="avatar"]');
                        const avatarPreview = document.querySelector('.avatar-preview-form');
    
                        if (avatarInput && avatarPreview) {
                            avatarInput.addEventListener('change', function(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        avatarPreview.src = e.target.result;
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                        }
                    });
                </script>
            </div>
        </main>
        HTML;
        
        return sprintf($template, $title, $content);
    }
}