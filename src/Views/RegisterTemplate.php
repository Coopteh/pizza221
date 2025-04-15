<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class RegisterTemplate extends BaseTemplate
{
    public static function getRegisterTemplate(): string {
        $template = parent::getTemplate();
        $title= 'Регистрация пользователя';
        $content = <<<FORM
        <main class="row p-5">
            <h1 class="mb-5">Регистрация пользователя</h1>
            <form action="/pizza221/register" method="POST">
                <div class="mb-3">
                    <label for="usernameInput" class="form-label">Имя пользователя:</label>
                    <input type="text" name="username" class="form-control" id="usernameInput" required>
                </div>
                <div class="mb-3">
                    <label for="emailInput" class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" id="emailInput" required>
                </div>
                <div class="mb-3">
                    <label for="passwordInput" class="form-label">Пароль:</label>
                    <input type="password" name="password" class="form-control" id="passwordInput" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPasswordInput" class="form-label">Подтвердите пароль:</label>
                    <input type="password" name="confirm_password" class="form-control" id="confirmPasswordInput" required>
                </div>
                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            </form>
        </main>
        FORM;

        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }
}
