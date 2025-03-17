<?php
namespace App\Views;
use App\Views\BaseTemplate;

class ProductTemplate extends BaseTemplate {
    public static function getCardTemplate(array $data) {
        $template = parent::getTemplate();
        $title = 'Главная страница';

        $content = <<<HTML
       <section>
       <div class="card" style="width: 18rem;">
  <img src="pizza221/assets/images/puma.png" class="card-img-top" alt="puma crosi">
  <div class="card-body">
    <h5 class="card-title">Puma кроссовки</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
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