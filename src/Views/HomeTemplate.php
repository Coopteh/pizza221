<?php
namespace App\Views;
use App\Views\BaseTemplate;

class HomeTemplate extends BaseTemplate {
    public static function getTemplate(): string {
        $template = parent::getTemplate();
        $title = 'Главная страница';
    
        $content = <<<HTML
    <section>
    <div class="h-50 w-50 mx-auto">        
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" style="height:65vh;">
                        <div class="carousel-item active">
                        <img src="./assets/images/молоко.png" class="d-block w-100 h-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="./assets/images/круггецы.png" class="d-block w-70 h-70 " alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="assets/images/кола.png" class="d-block w-100 h-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
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