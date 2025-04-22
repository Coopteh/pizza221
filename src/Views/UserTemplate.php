<?php 
namespace App\Views;

use App\Views\BaseTemplate;

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
        $html= <<<FORMA
                <form action="/pizza221/login" method="POST">
                    <div class="mb-3">
                        <label for="nameInput" class="form-label">Логин (имя или емайл):</label>
                        <input type="text" name="username" class="form-control" id="nameInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwordInput" class="form-label">Пароль:</label>
                        <input type="password" name="password" class="form-control" id="passwordInput">
                    </div>
                    <button type="submit" class="btn btn-primary mb-3">Войти</button>
                </form>
        FORMA;
        return $html;
    }
}