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
        <main class="row p-5 justify-content-center align-items-center">
            <div class="col-5 bg-light border rounded shadow-lg" style="background-color: #f8f9fa;">
                <h3 class="mb-4 text-center text-dark">Регистрация пользователя</h3>
        CORUSEL;
        $content .= self::getFormRegister();
        $content .= "</div></main>";

        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }

    public static function getVerifyTemplate(): string {
        $template = parent::getTemplate();
        $title= 'Подтверждение нового пользователя';
        $content = <<<CORUSEL
        <main class="row p-5 justify-content-center align-items-center">
            <div class="col-5 bg-light border rounded shadow-lg" style="background-color: #f8f9fa;">
                <h3 class="mb-4 text-center text-dark">Успешное завершение регистрации</h3>
        CORUSEL;
        $content .= "Ваш email успешно подтвержден!<br>
        Теперь вы можете войти на сайт";
        $content .= "</div></main>";

        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }


    /* 
        Форма регистрации (имя, емайл, пароль)
    */
    public static function getFormRegister(): string {
        $html= <<<FORMA
                <form action="/pizza221/register" method="POST" class="p-4">
                    <div class="mb-3">
                        <label for="nameInput" class="form-label text-dark">Имя пользователя:</label>
                        <input type="text" name="username" class="form-control" id="nameInput" required style="border: 1px solid #ced4da; background-color: #e9ecef;">
                    </div>
                    <div class="mb-3">
                        <label for="emailInput" class="form-label text-dark">Емайл:</label>
                        <input type="email" name="email" class="form-control" id="emailInput" required style="border: 1px solid #ced4da; background-color: #e9ecef;">
                    </div>
                    <div class="mb-3">
                        <label for="passwordInput" class="form-label text-dark">Пароль:</label>
                        <input type="password" name="password" class="form-control" id="passwordInput" required style="border: 1px solid #ced4da; background-color: #e9ecef;">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_passwordInput" class="form-label text-dark">Подтверждение пароля:</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_passwordInput" required style="border: 1px solid #ced4da; background-color: #e9ecef;">
                    </div>      
                    <button type="submit" class="btn btn-dark w-100 mb-3">Зарегистрироваться</button>
                </form>
        FORMA;
        return $html;
    }
}