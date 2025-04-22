<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class HomeTemplate extends BaseTemplate
{
    public static function getTemplate(): string {
        $template = parent::getTemplate();
        $title= 'Главная страница';
        $content = <<<CORUSEL
        <section>        
            <div class="h-50 w-50 mx-auto">        
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" style="height:65vh;">
                        <div class="carousel-item active">
                        <img src="./assets/images/image2.webp" class="d-block w-100 h-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="./assets/images/image1.webp" class="d-block w-100 h-100 " alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="./assets/images/image3.webp" class="d-block w-100 h-100" alt="...">
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
        <main class="row">
            <div class="p-5">
                <p>Здесь можно заказать мебель с доставкой по городу Кемерово.</p>
                <p>Широкий ассортимент, низкие цены, быстрая доставка!<br><br></p>
                <p> (*) Сайт разработан в рамках обучения в "Кузбасском кооперативном техникуме" по специальности "Специалист по информационным технологиям".</p>
            </div>
        </main>        
        CORUSEL;
        
        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }
}