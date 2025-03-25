<?php
namespace App\Views;

class BaseTemplate
{
    public static function getTemplate()
    {
        $template = <<<HTML
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>%s</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
            <!-- Custom CSS -->
            <style>
                body {
                    font-family: 'Roboto', sans-serif; /* Устанавливаем современный шрифт */
                    font-size: 16px; /* Базовый размер шрифта */
                    line-height: 1.6; /* Межстрочный интервал */
                    background-color: #f8f9fa; /* Светлый фон */
                    color: #343a40; /* Темно-серый текст */
                }
                header {
                    margin-bottom: 2rem; /* Отступ после заголовка */
                }
                .navbar-brand img {
                    margin-right: 10px; /* Расстояние между логотипом и текстом */
                }
                .navbar-brand {
                    font-size: 1.5rem; /* Размер текста в логотипе */
                    font-weight: bold; /* Жирный шрифт */
                    color: rgb(208,157,176) !important; /* Цвет текста логотипа */
                }
                .navbar-nav .nav-link {
                    font-size: 1.1rem; /* Размер текста в меню */
                    color: #343a40 !important; /* Цвет ссылок */
                    margin-right: 1.5rem; /* Расстояние между кнопками */
                }
                .navbar-nav .nav-link:hover {
                    color: rgb(208,157,176) !important; /* Цвет ссылок при наведении */
                }
                /* Стили для кнопок Bootstrap */
                .btn-custom {
                    background-color: rgb(208,157,176); /* Основной цвет кнопки */
                    border-color: rgb(208,157,176); /* Цвет границы */
                    color: #ffffff; /* Цвет текста */
                }
                .btn-custom:hover {
                    background-color: rgb(180,130,150); /* Цвет при наведении */
                    border-color: rgb(180,130,150); /* Цвет границы при наведении */
                    color: #ffffff; /* Цвет текста */
                }
                .alert {
                    margin-top: 1rem; /* Отступ сверху для flash-сообщений */
                    border-radius: 0.5rem; /* Закругление углов */
                }
                
                .btn-outline-primary{
                    background-color: rgb(180,130,150); /* Цвет при наведении */
                    border-color: rgb(180,130,150); /* Цвет границы при наведении */
                    color: #ffffff; /* Цвет текста */
                }
                main {
                    min-height: 70vh; /* Минимальная высота контента */
                }
                footer {
                    text-align: center; /* Текст по центру */
                    padding: 1rem 0; /* Внутренние отступы */
                    background-color: #343a40; /* Темный фон футера */
                    color: #ffffff; /* Белый текст */
                    font-size: 0.9rem; /* Размер текста футера */
                }
                .alert-custom {
                    background-color: #d4edda; /* Зеленый фон */
                    border-color: #c3e6cb; /* Зеленая граница */
                    color: #155724; /* Темно-зеленый текст */
                    
                }

                .alert-custom .btn-close {
                    color: #ffffff; /* Цвет кнопки закрытия */
                    opacity: 0.8; /* Прозрачность кнопки закрытия */
                }

                .alert-custom .btn-close:hover {
                    color:rgb(141, 34, 123); /* Цвет кнопки закрытия при наведении */
                    opacity: 1; /* Убираем прозрачность */
                }
            </style>
            <script src="../../assets/css/bootstrap.bundle.js"></script>
        </head>
        <body>
            <header>
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="http://localhost/">
                            <img src="https://e7.pngegg.com/pngimages/890/893/png-clipart-pizza-logo-pizza-delivery-italian-cuisine-chef-pizza-icon-logo-design-food-logo.png" alt="Логотип компании" width="64" height="64">
                            ПИЦЦЕРИЯ ИС-221®
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav"> <!-- Убран ms-auto -->
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="http://localhost/">Главная</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="http://localhost/about">О нас</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="http://localhost/products">Каталог</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="http://localhost/order">Заказ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
        HTML;

        // Добавим flash сообщение
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['flash'])) {
            $template .= <<<END
                <div id="liveAlertBtn" class="container alert alert-custom alert-dismissible fade show" role="alert">
                    <div>{$_SESSION['flash']}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    onclick="this.parentNode.style.display='none';"></button>
                </div>
            END;
            unset($_SESSION['flash']);
        }

        $template .= <<<HTML
            <main class="container mt-4">
                %s
            </main>

            <footer class="mt-5">
                © 2025 «Кемеровский кооперативный техникум»
            </footer>
        </body>
        </html>
        HTML;

        return $template;
    }
}