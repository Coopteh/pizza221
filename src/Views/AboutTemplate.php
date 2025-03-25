<?php
namespace App\Views;
use App\Views\BaseTemplate;

class AboutTemplate extends BaseTemplate
{
    public static function getTemplate()
    {
        $template = parent::getTemplate();
        $title = 'О нас';
        $content = <<<HTML

        <!-- Подключение Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <div class="container mt-5">
            <h1 class="text-center mb-4">О нас</h1>
            <p class="lead text-center">
                Кемеровский кооперативный техникум — это первый шаг на пути к будущей успешной карьере.
            </p>

            <!-- Блок с контактной информацией -->
            <section class="row mt-5">
                <div class="col-md-6">
                    <h3 class="mb-4"><i class="fas fa-info-circle me-2"></i>Контактная информация</h3>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt me-2"></i>Адрес: г. Кемерово, ул. Ленина, 123</li>
                        <li><i class="fas fa-phone me-2"></i>Телефон: +7 (777) 666 55 44</li>
                        <li><i class="fas fa-envelope me-2"></i>Email: Soborovets@gmail.com</li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <h3 class="mb-4"><i class="fas fa-link me-2"></i>Ссылки на меня</h3>
                    <ul class="list-unstyled d-flex flex-wrap gap-3">
                        <li>
                            <a href="https://github.com/GsaiberS" target="_blank" class="btn btn-custom btn-sm d-flex align-items-center gap-2">
                                <i class="fab fa-github"></i> GitHub
                            </a>
                        </li>
                        <li>
                            <a href="https://vk.com/rsoborovets" target="_blank" class="btn btn-custom btn-sm d-flex align-items-center gap-2">
                                <i class="fab fa-vk"></i> VK
                            </a>
                        </li>
                        <li>
                            <a href="https://t.me/Rsobr" target="_blank" class="btn btn-custom btn-sm d-flex align-items-center gap-2">
                                <i class="fab fa-telegram"></i> Telegram
                            </a>
                        </li>
                        <li>
                            <a href="https://steamcommunity.com/profiles/76561199438628487/" target="_blank" class="btn btn-custom btn-sm d-flex align-items-center gap-2">
                                <i class="fab fa-steam"></i> Steam
                            </a>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- Карта -->
            <section class="mt-5">
                <h3 class="mb-4"><i class="fas fa-map-marked-alt me-2"></i>Мы на карте</h3>
                <div style="position:relative;overflow:hidden;">
                    <iframe 
                        src="https://yandex.ru/map-widget/v1/?ll=86.133386%2C55.332456&mode=poi&poi%5Bpoint%5D=86.133796%2C55.333990&poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D1018378103&z=17.14" 
                        width="100%" 
                        height="400" 
                        frameborder="0" 
                        allowfullscreen="true" 
                        style="border-radius: 8px;">
                    </iframe>
                </div>
            </section>
        </div>
HTML;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}