<?php
namespace App\Views;

class BaseTemplate
{
    public static function getTemplate()
    {
        global $user_id, $username;

        $template = <<<LINE
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>%s</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.x.x/dist/css/bootstrap.min.css" rel="stylesheet">
            <!-- Custom CSS -->
            <style>
                body {
                    font-family: 'Roboto', sans-serif;
                    font-size: 16px;
                    line-height: 1.6;
                    background-color: #f8f9fa;
                    color: #343a40;
                }
                header {
                    margin-bottom: 2rem;
                }
                .navbar-brand img {
                    margin-right: 10px;
                }
                .navbar-brand {
                    font-size: 1.5rem;
                    font-weight: bold;
                    color: rgb(208,157,176) !important;
                }
                .navbar-nav .nav-link {
                    font-size: 1.1rem;
                    color: #343a40 !important;
                    margin-right: 1.5rem;
                }
                .navbar-nav .nav-link:hover {
                    color: rgb(208,157,176) !important;
                }
                /* Кнопка регистрации */
                .btn-register {
                    background-color: rgb(208,157,176);
                    border-color: rgb(208,157,176);
                    color: #ffffff;
                    transition: all 0.3s ease-in-out;
                }
                .btn-register:hover {
                    background-color: rgb(215, 93, 138);
                    border-color: rgb(215, 93, 138);
                }
                /* Иконки для кнопок */
                .nav-link i {
                    margin-right: 8px;
                }
                /* Алерты */
                .alert-custom {
                    background-color: #d4edda;
                    border-color: #c3e6cb;
                    color: #155724;
                }
                .alert-custom .btn-close {
                    color: #ffffff;
                    opacity: 0.8;
                }
                .alert-custom .btn-close:hover {
                    color: rgb(141, 34, 123);
                    opacity: 1;
                }
                /* Футер */
                footer {
                    text-align: center;
                    padding: 1rem 0;
                    background-color: #343a40;
                    color: #ffffff;
                    font-size: 0.9rem;
                }
                /* Выпадающее меню регистрации */
                .dropdown-menu {
                    background-color: rgba(255, 255, 255, 0.95);
                    border-radius: 10px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }
                .dropdown-item {
                    color: #343a40;
                    transition: all 0.3s ease-in-out;
                }
                .dropdown-item:hover {
                    background-color: rgb(208,157,176);
                    color: #ffffff;
                }
                /* Анимация появления */
                .animate__fadeIn {
                    animation-duration: 1s;
                }
                .btn-custom{
                    background-color: rgb(208,157,176);
                    border-color: rgb(208,157,176);
                    color: #ffffff;
                    transition: all 0.3s ease-in-out;
                }
                .btn-custom:hover {
                }
                .btn-outline-primary {
                    background-color: rgb(208,157,176);
                    border-color: rgb(208,157,176);
                    color: #ffffff;
                    transition: all 0.3s ease-in-out;
                }
                .btn-outline-primary:hover {
                    background-color: rgb(215, 93, 138);
                    border-color: rgb(215, 93, 138);
                }
            </style>
            <script src="../../assets/css/bootstrap.bundle.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.x.x/dist/js/bootstrap.bundle.min.js"></script>
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
                            <ul class="navbar-nav me-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="http://localhost/">
                                        <i class="fas fa-home"></i>Главная
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="http://localhost/about">
                                        <i class="fas fa-info-circle"></i>О нас
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="http://localhost/products">
                                        <i class="fas fa-pizza-slice"></i>Каталог
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="http://localhost/order">
                                        <i class="fas fa-shopping-cart"></i>Заказ
                                    </a>
                                </li>
                            </ul>
LINE;

        if ($user_id > 0) {
            $template .= <<<LINE
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {$username}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="http://localhost/profile"><i class="fas fa-user"></i>Профиль</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="http://localhost/logout"><i class="fas fa-sign-out-alt"></i>Выход</a></li>
                                    </ul>
                                </li>
                            </ul>
LINE;
        } else {
            $template .= <<<LINE
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <button class="btn btn-register dropdown-toggle" id="registerDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-plus"></i>Регистрация
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn" aria-labelledby="registerDropdown">
                                        <li><a class="dropdown-item" href="http://localhost/register"><i class="fas fa-sign-in-alt"></i>Зарегистрироваться</a></li>
                                        <li><a class="dropdown-item" href="http://localhost/login"><i class="fas fa-user"></i>Войти</a></li>
                                    </ul>
                                </li>
                            </ul>
LINE;
        }

        $template .= <<<LINE
                        </div>
                    </div>
                </nav>
            </header>
LINE;

        // Добавим flash сообщение
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

        $template .= <<<LINE
            <main class="container mt-4">
                %s
            </main>
            <footer class="mt-5 bg-dark text-white py-5">
                <div class="container">
                    <div class="row justify-content-between">
                        <!-- Секция контактов -->
                        <div class="col-md-4 mb-4">
                            <h5 class="text-uppercase fw-bold">Контакты</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-map-marker-alt me-2"></i><span class="text-light">Адрес: г. Кемерово, ул. Тухочевского, 32</span></li>
                                <li><i class="fas fa-phone me-2"></i><span class="text-light">Телефон: +7 (999) 777-99-71</span></li>
                                <li><i class="fas fa-envelope me-2"></i><span class="text-light">Email: info@pizzeria-is221.ru</span></li>
                            </ul>
                        </div>
                        <!-- Секция социальных сетей -->
                        <div class="col-md-4 mb-4 text-center">
                            <h5 class="text-uppercase fw-bold">Мы в социальных сетях</h5>
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <a href="https://vk.com" target="_blank" class="text-white"><i class="fab fa-vk fa-2x"></i></a>
                                <a href="https://instagram.com" target="_blank" class="text-white"><i class="fab fa-instagram fa-2x"></i></a>
                                <a href="https://telegram.org" target="_blank" class="text-white"><i class="fab fa-telegram fa-2x"></i></a>
                            </div>
                        </div>
                        <!-- Секция видео с Rutube -->
                        <div class="col-md-4 mb-4">
                            <h5 class="text-uppercase fw-bold">Видео о нас</h5>
                            <div class="ratio ratio-16x9">
                                <iframe 
                                    src="https://rutube.ru/play/embed/938c7ce98486d2b597640b4bbb236550?autoplay=1" 
                                    allow="autoplay; fullscreen" 
                                    allowfullscreen 
                                    title="Видео с Rutube"
                                    style="border: none;"
                                ></iframe>
                            </div>
                        </div>
                    </div>
                    <!-- Нижняя часть футера -->
                    <div class="row mt-4">
                        <div class="col text-center">
                            <p class="mb-0 small text-light">&copy; 2025 «Кемеровский кооперативный техникум» | Все права защищены</p>
                            <p class="mb-0 small text-light">Разработано студентами группы ИС-221</p>
                        </div>
                    </div>
                </div>
            </footer>
        </body>
        </html>
LINE;

        return $template;
    }
}
