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
    <img src="https://avatars.mds.yandex.net/i?id=a436ddff27225ea3ae95e73be1ab98f1450f46ff-11043615-images-thumbs&n=13" class="d-block w-100" alt="/////">
</div>
<div class="carousel-item">
    <img src="https://avatars.mds.yandex.net/i?id=f398045933a605093ba09031383512cb78aeb6cc-4478710-images-thumbs&n=13" class="d-block w-100" alt="////">
</div>
<div class="carousel-item">
    <img src="https://avatars.mds.yandex.net/i?id=aad9163d9aa9437b37cc886f98f6a3035d6f4687-10803836-images-thumbs&n=13" class="d-block w-100" alt="///">  <!-- src="assets/images/img3.jpg"-->
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
Здесь можно заказать пиццу доставкой по городу Кемерово.<br>
Широкий ассортимент, низкие цены, быстрая доставка!<br><br>
(*) Сайт разработан в рамках обучения в "Кузбасском кооперативном техникуме" по специальности "Специалист по информационным технологиям"
</main>

HTML;
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}