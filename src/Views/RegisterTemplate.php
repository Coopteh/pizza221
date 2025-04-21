<?php

namespace App\Views;
use App\Views\BaseTemplate;

class RegisterTemplate extends BaseTemplate
{
    
    public static function getRegisterTemplate(): string
    {
        $template = parent::getTemplate();
        $title = 'Регистрация';

        // Основной контент страницы
        $content = <<<HTML
        <!-- Фоновая секция -->
        <div class="register-page d-flex align-items-start justify-content-center min-vh-100" style="background: linear-gradient(135deg, #f8f9fa, rgb(208,157,176), #fff); background-size: cover; background-position: center; background-repeat: no-repeat;">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-10">
                        <!-- Карточка регистрации -->
                        <div class="card shadow-lg p-4 animate__animated animate__fadeInUp" style="border-radius: 20px; background: rgba(255, 255, 255, 0.95);">
                            <div class="text-center mb-4">
                                <h1 class="display-4 fw-bold" style="color: rgb(208,157,176);">Регистрация</h1>
                                <p class="text-muted">Создайте учетную запись для доступа к платформе</p>
                            </div>

                            <!-- Форма регистрации -->
                            <form action="/register" method="POST">
                                <!-- Имя пользователя -->
                                <div class="mb-3 input-group hover-scale">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-user" style="color: rgb(208,157,176);"></i>
                                    </span>
                                    <input type="text" name="username" class="form-control border-start-0" placeholder="Имя пользователя" required style="border-radius: 0 10px 10px 0;">
                                </div>

                                <!-- Email -->
                                <div class="mb-3 input-group hover-scale">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-envelope" style="color: rgb(208,157,176);"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control border-start-0" placeholder="Email" required style="border-radius: 0 10px 10px 0;">
                                </div>

                                <!-- Пароль -->
                                <div class="mb-3 input-group hover-scale">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-lock" style="color: rgb(208,157,176);"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control border-start-0" placeholder="Пароль" required style="border-radius: 0 10px 10px 0;">
                                </div>

                                <!-- Подтверждение пароля -->
                                <div class="mb-3 input-group hover-scale">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="fas fa-lock" style="color: rgb(208,157,176);"></i>
                                    </span>
                                    <input type="password" name="confirm_password" class="form-control border-start-0" placeholder="Подтвердите пароль" required style="border-radius: 0 10px 10px 0;">
                                </div>

                                <!-- Кнопка регистрации -->
                                <button type="submit" class="btn w-100 mt-4 hover-scale" style="background: linear-gradient(135deg, rgb(208,157,176), #d1a7b9); color: white; border: none; border-radius: 10px; font-size: 1.1rem; transition: all 0.6s ease-in-out;">
                                    <i class="fas fa-sign-in-alt me-2"></i>Зарегистрироваться
                                </button>
                            </form>

                            <!-- Ссылка на вход -->
                            <div class="text-center mt-4">
                                <p class="text-muted">Уже есть аккаунт? <a href="/login" class="hover-underline" style="color: rgb(208,157,176); text-decoration: none; font-weight: bold;">Войти</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Анимации -->
        <style>
            /* Плавное появление карточки */
            .animate__fadeInUp {
                animation-duration: 1.5s;
            }

            /* Эффект увеличения при наведении */
            .hover-scale {
                will-change: transform;
                backface-visibility: hidden;
                transition: transform 0.6s ease-in-out;
            }

            .hover-scale:hover {
                transform: scale(1.03);
            }

            /* Подчеркивание ссылки при наведении */
            .hover-underline:hover {
                text-decoration: underline;
                color: #d1a7b9;
                transition: color 0.6s ease-in-out;
            }

            /* Автономная анимация текста */
            .text-muted {
                animation: fadeInText 4s ease-in-out infinite alternate;
            }

            @keyframes fadeInText {
                0% {
                    opacity: 0.9;
                }
                100% {
                    opacity: 1;
                }
            }

            /* Улучшение читаемости текста */
            button, input {
                text-rendering: optimizeLegibility;
            }
        </style>
HTML;

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

        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }
}