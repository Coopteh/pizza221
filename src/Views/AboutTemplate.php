<?php
namespace App\Views;

class AboutTemplate extends BaseTemplate {
    public static function getTemplate() : string  {
        $template = parent::getTemplate();
        $title = 'О нас';
        
        $content = '
        <p>Кузбасский кооперативный техникум (ККТ) - это образовательное учреждение.</p>
        <p>На сайте <a href="http://coopteh.ru">coopteh.ru</a> вы можете найти подробную информацию о техникуме.</p>
        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A8b08475f0a7976f4e982d65895d28c45d545c2898714778846640898f484162c&amp;source=constructor" width="600" height="450" frameborder="0"></iframe>
        ';
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}