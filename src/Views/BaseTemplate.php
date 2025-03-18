<?php

namespace App\Views;

class BaseTemplate
{
    public static function getTemplate()
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>%s</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <script src="../../assets/css/bootstrap.bundle.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="" >
                    
                    <img src="./../assets/image/logo.png" alt="Логотип компании" width="64" height="64"  class="logo">
                  
                    Cerberus
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="http://localhost/">Главная</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="http://localhost/about">О нас</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="http://localhost/product/">Каталог</a>
                    </li>
                </ul>
                </div>
                
            </div>
        </nav>
     </header>
    <main class="container mt-4">
        %s

        <footer class="mt-5">
                © 2025 «Кемеровский кооперативный техникум»
        <footer>
    </main>
</body>
</html>
HTML;
    }
}