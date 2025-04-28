<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class RegisterTemplate extends BaseTemplate
{
    /*
        Формирование страница "Регистрация"
    */
    public static function getRegisterTemplate(): string {
        $template = parent::getTemplate();
        $title= 'Регистрация нового пользователя';
        $content = <<<CORUSEL
        <style>
            :root {
                --bg-color: #e9ecef; /* Светло-серый фон */
                --card-bg: #ffffff; /* Белый фон карточки */
                --text-color: #495057; /* Темно-серый текст */
                --border-color: #ced4da; /* Серый цвет границ */
                --primary-color: #6c757d; /* Серый цвет кнопки */
            }

            body {
                background-color: var(--bg-color);
            }

            .registration-card {
                background-color: var(--card-bg);
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 2rem;
            }

            .form-label {
                color: var(--text-color);
            }

            .form-control {
                border: 1px solid var(--border-color);
            }

            .btn-primary {
                background-color: var(--primary-color);
                border: none;
                color: white;
                transition: opacity 0.3s ease; /* Плавный переход для opacity */
            }

            .btn-primary:hover {
                opacity: 0.7; /* Полупрозрачность при наведении */
            }
        </style>
        <main class="row p-5 justify-content-center align-items-center">
            <div class="col-5 registration-card">
                <h3 class="mb-5 text-center">Регистрация пользователя</h3>
        CORUSEL;
        $content .= self::getFormRegister();
        $content .= "</div></main>";

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }

    public static function getVerifyTemplate(): string {
        $template = parent::getTemplate();
        $title= 'Подтверждение нового пользователя';
        $content = <<<CORUSEL
        <main class="row p-5 justify-content-center align-items-center">
            <div class="col-5 bg-light border">
                <h3 class="mb-5">Успешное завершение регистрации</h3>
        CORUSEL;
        $content .= "Ваш email успешно подтвержден!<br>
                     Теперь вы можете войти на сайт";
        $content .= "</div></main>";

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }


    /* 
        Форма регистрации (имя, емайл, пароль)
    */
    public static function getFormRegister(): string {
        $html= <<<FORMA
                <form action="/pizza221/register" method="POST">
                    <div class="mb-3">
                        <label for="nameInput" class="form-label">Имя пользователя:</label>
                        <input type="text" name="username" class="form-control" id="nameInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailInput" class="form-label">Емайл:</label>
                        <input type="email" name="email" class="form-control" id="emailInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwordInput" class="form-label">Пароль:</label>
                        <input type="password" name="password" class="form-control" id="passwordInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_passwordInput" class="form-label">Подтверждение пароля:</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_passwordInput" required>
                    </div>      
                    <button type="submit" class="btn btn-primary mb-3 w-100">Зарегистрироваться</button>
                </form>
        FORMA;
        return $html;
    }
}