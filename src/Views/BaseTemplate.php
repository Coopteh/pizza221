<?php 
namespace App\Views;

class BaseTemplate 
{
    public static function getTemplate(): string {
        global $user_id, $username;

        $template = <<<HTML
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>%s</title>
            <link rel="stylesheet" href="/avtoservis/assets/css/bootstrap.min.css">
            <script src="/avtoservis/assets/js/bootstrap.bundle.js"></script>
        <body>
        <script src="/avtoservis/assets/js/wheel.js" defer></script>
            <header>
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="https://localhost/avtoservis/assets/images/logo.png" alt="Логотип компании" width="64" height="64">
                        Автосервис
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/avtoservis/">Главная</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/avtoservis/products">Услуги</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/avtoservis/register">Регистрация</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/avtoservis/order">Заказ</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/avtoservis/about">О нас</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/avtoservis/history">Записи заказов</a>
                        </li>
                    </ul>
                    </div>
                </div>
        HTML;

        // Проверка, авторизован ли пользователь
        if ($user_id > 0) {
            $template .= <<<HTML
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {$username}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/avtoservis/profile">Профиль</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/avtoservis/logout">Выход</a></li>
                        </ul>
                    </li>
                </ul>
            HTML;
        } else {
            $template .= <<<HTML
                <a class="nav-link p-3" href="/avtoservis/login">Вход</a>
            HTML;    
        }

        $template .= "</nav></header>";

        // Добавление флэш-сообщения
        if (isset($_SESSION['flash'])) {
            $template .= <<<END
                <div id="liveAlertBtn" class="alert alert-info alert-dismissible" role="alert">
                    <div>{$_SESSION['flash']}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    onclick="this.parentNode.style.display='none';"></button>
                </div>
            END;
            unset($_SESSION['flash']); // Удаляем сообщение после отображения
        }

        $template .= <<<HTML
            %s
            <footer class="mt-3 p-3">
                © 2025 «Кемеровский кооперативный техникум»
            </footer>
        </body>
        </html>
        HTML;

        return $template;
    }
}