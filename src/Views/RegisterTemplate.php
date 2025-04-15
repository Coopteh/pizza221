<?php

namespace App\Views;
use App\Views\BaseTemplate;

class RegisterTemplate extends BaseTemplate
{
    public static function getRegisterTemplate(): string
    {
        $template = parent::getTemplate();
        $title = 'Регистрация';

        // Заголовок
        $content = <<<HTML
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold" style="color: rgb(208,157,176);">Регистрация</h1>
            <p class="text-muted">Создайте учетную запись для доступа к платформе</p>
        </div>
HTML;

        // Форма регистрации
        $content .= <<<HTML
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card shadow p-4" style="border-radius: 20px; background-color: #fff;">
                    <form action="/register" method="POST">
                        <!-- Имя пользователя -->
                        <div class="mb-3 input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                <i class="fas fa-user" style="color: rgb(208,157,176);"></i>
                            </span>
                            <input type="text" name="username" class="form-control border-start-0" placeholder="Имя пользователя" required style="border-radius: 0 10px 10px 0;">
                        </div>

                        <!-- Email -->
                        <div class="mb-3 input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                <i class="fas fa-envelope" style="color: rgb(208,157,176);"></i>
                            </span>
                            <input type="email" name="email" class="form-control border-start-0" placeholder="Email" required style="border-radius: 0 10px 10px 0;">
                        </div>

                        <!-- Пароль -->
                        <div class="mb-3 input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                <i class="fas fa-lock" style="color: rgb(208,157,176);"></i>
                            </span>
                            <input type="password" name="password" class="form-control border-start-0" placeholder="Пароль" required style="border-radius: 0 10px 10px 0;">
                        </div>

                        <!-- Подтверждение пароля -->
                        <div class="mb-3 input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                <i class="fas fa-lock" style="color: rgb(208,157,176);"></i>
                            </span>
                            <input type="password" name="confirm_password" class="form-control border-start-0" placeholder="Подтвердите пароль" required style="border-radius: 0 10px 10px 0;">
                        </div>

                        <!-- Кнопка регистрации -->
                        <button type="submit" class="btn btn-custom w-100 mt-4" style=" color: white; border: none; border-radius: 10px; font-size: 1.1rem; transition: transform 0.2s ease-in-out;">
                            <i class="fas fa-sign-in-alt me-2"></i>Зарегистрироваться
                        </button>
                    </form>

                    <!-- Ссылка на вход -->
                    <div class="text-center mt-4">
                        <p class="text-muted">Уже есть аккаунт? <a href="/login" style="color: rgb(208,157,176); text-decoration: none; font-weight: bold;">Войти</a></p>
                    </div>
                </div>
            </div>
        </div>
HTML;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}