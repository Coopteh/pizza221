<?php 
namespace App\Views;
class BaseTemplate 
{
    public static function getTemplate(): string {
        global $user_id, $username;

        $template = <<<LINE
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title> %s </title>
            <link rel="stylesheet" href="https://localhost/pizza221/assets/css/bootstrap.min.css">
            <script src="https://localhost/pizza221/assets/js/bootstrap.bundle.js"></script>
        </head>
        <body>
            <header>
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="https://localhost/pizza221/assets/images/logotype.jpg" alt="Логотип компании" width="64" height="64">
                        КАК ПОПАЛО
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/pizza221/">Главная</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/pizza221/products">Каталог</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/pizza221/about">О нас</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/pizza221/order">Заказ</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/pizza221/register">Регистрация</a>
                        </li>
                    </ul>
                    </div>
                </div>
        LINE;

if ($user_id > 0) {
        $template .= <<<LINE
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {$username}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/pizza221/profile">Профиль</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/pizza221/logout">Выход</a></li>
                        </ul>
                    </li>
                </ul>
        LINE;
} else {
    $template .= <<<LINE
        <a class="nav-link p-3" href="/pizza221/login">
        Вход
        </a>
    LINE;    
}
        $template .= "</nav></header>";

        // Добавим flash сообщение
        if (isset($_SESSION['flash'])) {
            $template .= <<<END
                <div id="liveAlertBtn" class="alert alert-info alert-dismissible" role="alert">
                    <div>{$_SESSION['flash']}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    onclick="this.parentNode.style.display='none';"></button>
                </div>
            END;
            unset($_SESSION['flash']);
        }

        $template.= <<<LINE
            %s
            <footer class="mt-3 p-3">
                © 2025 «Кемеровский кооперативный техникум»
            <footer>
        </body>
        </html>
        LINE;

        return $template;
    }
}