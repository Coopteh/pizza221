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
    <img src="/basik/assets/images/puma.png" class="d-block w-100" alt="первый">
</div>
<div class="carousel-item">
    <img src="/basik/assets/images/fila.png" class="d-block w-100" alt="второй">
</div>
<div class="carousel-item">
    <img src="/basik/assets/images/demix.png" class="d-block w-100" alt="третий">  
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
</section>
<main>
Здесь можно заказать обвуь доставкой по городу Кемерово.<br>
Широкий ассортимент, низкие цены, быстрая доставка!<br><br>
(*) Сайт разработан в рамках обучения в "Кузбасском кооперативном техникуме" по специальности "Специалист по информационным технологиям"
</main>

HTML;
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}