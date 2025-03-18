<?php 
namespace App\Views;

class BaseTemplate 
{
    public static function getTemplate(): string {
        $template = <<<LINE
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title> %s </title>
            <link rel="stylesheet" href="http://localhost/Pizza221/assets/css/bootstrap.min.css">
            <script src="http://localhost/Pizza221/assets/js/bootstrap.bundle.js"></script>
        </head>
        <body>
            <header>
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="http://localhost/pizza221/">
                        <img src="http://localhost/Pizza221/assets/images/img5.jpeg" alt="Логотип компании" width="64" height="64">
                        ГОСТИНИЦА ИС-221
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="http://localhost/pizza221/">Главная</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="http://localhost/pizza221/about">О нас</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="http://localhost/pizza221/products">Каталог</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                        </li>
                    </ul>
                    </div>
                </div>
                </nav>
            </header>
        
            <div class="container mt-5 mb-5">
                %s
            </div>

            <footer class="mt-5">
                &copy; 2025 «Кемеровский кооперативный техникум»
            </footer>
        </body>
        </html>
        LINE;

        return $template;
    }
}
