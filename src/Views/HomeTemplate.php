<?php
namespace App\Views;
use App\Views\BaseTemplate;

class HomeTemplate extends BaseTemplate {
    public static function getTemplate(): string {
        $template = parent::getTemplate();
        $title = 'Главная страница';
    
        $content = <<<HTML
    <section>
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Слайды -->
                <div class="carousel-item active">
                    <img src="/pizza221/assets/images/img1.png" class="d-block w-100" alt="Первый слайд">
                </div>
                <div class="carousel-item">
                    <img src="/pizza221/assets/images/img2.png" class="d-block w-100" alt="Второй слайд">
                </div>
                <div class="carousel-item">
                    <img src="/pizza221/assets/images/img3.png" class="d-block w-100" alt="Третий слайд">
                </div>
                <!-- Контроллеры карусели -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    <main>
        <br><br><br>
        (*) Сайт разработан в рамках обучения в "Кузбасском кооперативном техникуме" по специальности "Специалист по информационным технологиям"
    </main>
    HTML;
    
        // Добавляем стили для изображений
        $styles = "
        <style>
            .carousel-item img {
                max-height: 400px; /* Максимальная высота */
                width: 100%;       /* Ширина адаптируется */
                object-fit: cover; /* Сохраняет пропорции */
            }
        </style>
        ";
    
        // Объединяем шаблон, стили и содержимое
        $resultTemplate = sprintf($template, $title, $styles . $content);
        return $resultTemplate;
    }
}