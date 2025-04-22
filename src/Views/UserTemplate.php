<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class UserTemplate extends BaseTemplate
{
    /*
        Формирование страницы "Регистрация"
    */
    public static function getUserTemplate(): string {
        $template = parent::getTemplate();
        $title = 'Вход пользователя';
        $content = <<<CORUSEL
        <main class="row p-5 justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5 col-md-7 bg-white border rounded shadow p-4 animate__animated animate__fadeIn">
                <h3 class="text-center mb-5" style="color: rgb(208,157,176);">Вход пользователя</h3>
        CORUSEL;
        $content .= self::getFormLogin();
        $content .= "</div></main>";

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }

    /* 
        Форма входа (логин, пароль)
    */
    public static function getFormLogin(): string {
        $html = <<<FORMA
                <form action="/login" method="POST" class="animate__animated animate__fadeInUp">
                    <!-- Логин -->
                    <div class="input-group mb-3 custom-input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-user text-muted"></i>
                        </span>
                        <input type="text" name="username" class="form-control" placeholder="Логин (имя или email)" required>
                    </div>

                    <!-- Пароль -->
                    <div class="input-group mb-3 custom-input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-lock text-muted"></i>
                        </span>
                        <input type="password" name="password" class="form-control" placeholder="Пароль" required>
                    </div>

                    <!-- Кнопка -->
                    <button type="submit" class="btn btn-custom w-100 mt-4" 
                            style="background-color: rgb(208,157,176); color: #ffffff; font-weight: bold;">
                        <i class="fas fa-sign-in-alt me-2"></i>Войти
                    </button>
                </form>
        FORMA;
        return $html;
    }

    /**
     * Форма редактирования профиля
     */
    public static function getProfileForm(array $userData = []): string {
        // Получаем базовый шаблон
        $template = parent::getTemplate();
        $title = 'Редактирование профиля';
    
        // Формируем содержимое страницы
        $username = htmlspecialchars($userData['username'] ?? '');
        $email = htmlspecialchars($userData['email'] ?? '');
        $address = htmlspecialchars($userData['address'] ?? '');
        $phone = htmlspecialchars($userData['phone'] ?? '');
    
        $content = <<<HTML
        <style>
        /* Стиль для групп полей ввода */
        .custom-input-group {
            position: relative;
            display: flex;
            align-items: center;
            border: 2px solid rgb(208, 157, 176);
            border-radius: 8px;
            overflow: hidden;
            transition: border-color 0.3s ease;
        }

        .custom-input-group:focus-within {
            border-color: rgb(180, 120, 150); /* Темнее при фокусе */
        }

        .custom-input-group .input-group-text {
            padding: 0.75rem 1rem;
            background-color: transparent;
            border: none;
            color: rgb(208, 157, 176);
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

        /* Кнопки */
        .btn-custom {}
        </style>
        <main class="row p-5 justify-content-center align-items-center min-vh-100">
            <div class="col-lg-6 col-md-8 bg-white border rounded shadow p-4 animate__animated animate__fadeIn">
                <h3 class="text-center mb-4" style="color: rgb(208,157,176);">Редактирование профиля</h3>
                <form action="/profile" method="POST" class="animate__animated animate__fadeInUp">

                    <!-- Имя пользователя -->
                    <div class="input-group mb-3 custom-input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-user-edit text-muted"></i>
                        </span>
                        <input type="text" name="username" class="form-control" id="username" value="{$username}" placeholder="Имя пользователя" required>
                    </div>

                    <!-- Email -->
                    <div class="input-group mb-3 custom-input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-envelope text-muted"></i>
                        </span>
                        <input type="email" name="email" class="form-control" id="email" value="{$email}" placeholder="Email" required>
                    </div>

                    <!-- Адрес -->
                    <div class="input-group mb-3 custom-input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-map-marker-alt text-muted"></i>
                        </span>
                        <input type="text" name="address" class="form-control" id="address" value="{$address}" placeholder="Адрес">
                    </div>

                    <!-- Телефон -->
                    <div class="input-group mb-3 custom-input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-phone text-muted"></i>
                        </span>
                        <input type="text" name="phone" class="form-control" id="phone" value="{$phone}" placeholder="Телефон">
                    </div>

                    <!-- Кнопка отправки -->
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-custom" 
                                style="background-color: rgb(208,157,176); color: #ffffff; font-weight: bold;">
                            <i class="fas fa-save me-2"></i>Сохранить изменения
                        </button>
                    </div>
                </form>
            </div>
        </main>
        HTML;
    
        // Вставляем содержимое в базовый шаблон
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}