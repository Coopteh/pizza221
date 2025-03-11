<?php
namespace App\Views;
use App\Views\BaseTemplate;

class AboutTemplate extends BaseTemplate {
    public static function getTemplate(): string {
        $template = parent::getTemplate();
        $title = 'О нас';
        $content = <<<HTML
<main>
Здесь можно заказать пиццу доставкой по городу Кемерово.<br>
Широкий ассортимент, низкие цены, быстрая доставка!<br><br>
(*) Сайт разработан в рамках обучения в "Кузбасском кооперативном техникуме" по специальности "Специалист по информационным технологиям"
<img src="https://yandex.ru/maps/64/kemerovo/?ll=86.134488%2C55.333767&mode=poi&poi%5Bpoint%5D=86.133799%2C55.333986&poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D1018378103&z=17.91" alt="Карта" style="width: 100%; height: auto;">
</main>

HTML;
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}