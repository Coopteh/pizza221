<?php
namespace App\Views;
use App\Views\BaseTemplate;

class AboutTemplate extends BaseTemplate {
    public static function getTemplate(): string {
        $template = parent::getTemplate();
        $title = 'О нас';
        $content = <<<HTML
(*) Сайт разработан в рамках обучения в "Кузбасском кооперативном техникуме" по специальности "Специалист по информационным технологиям"
<img src="/pizza221/assets/images/KKT.png" alt="Карта" style="width: 100%; height: auto;">
HTML;
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}