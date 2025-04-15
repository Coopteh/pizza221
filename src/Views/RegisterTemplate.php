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
        <main class="row p-5">
            <h1 class="mb-5">Регистрация пользователя</h1>
        CORUSEL;
        $content .= self::getFormRegister();
        $content .= "</main>";

        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }

    /* 
        Форма регистрации (имя, емайл, пароль)
    */
    public static function getFormRegister(): string {
        $html= <<<FORMA
                <form action="/trenazherka/register" method="POST">
                    <div class="mb-3">
                        <label for="nameInput" class="form-label">Имя пользователя:</label>
                        <input type="text" name="username" class="form-control" id="nameInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailInput" class="form-label">Емайл:</label>
                        <input type="email" name="email" class="form-control" id="emailInput">
                    </div>
                    <div class="mb-3">
                        <label for="passwordInput" class="form-label">Пароль:</label>
                        <input type="password" name="password" class="form-control" id="passwordInput">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_passwordInput" class="form-label">Подтверждение пароля:</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_passwordInput">
                    </div>      
                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                </form>
        FORMA;
        return $html;
    }
}