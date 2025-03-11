<?php

namespace App\Views;

use App\Views\BaseTemplate;

class AboutTemplate extends BaseTemplate {
    public static function getTemplate() {
        $template = parent::getTemplate(); 
        $title = 'Главная страница'; 
        $content = <<<Corusel
        
        <p>О нас.</p>
         <img src="https://localhost/AutoParts/assets/images/carta.png" class="d-block w-100vh" alt="...">
        <p>Кемеровский кооперативный техникум сегодня – это первый шаг на пути к будущей успешной карьере.</p>
        <p>Кемеровский кооперативный техникум был основан в 1974 году в связи с потребностью в</p>
        <p>специалистах для предприятий и организаций потребительской кооперации Кемеровской области.</p><br>
        <p>Сайт разработан в рамках обучения в "Кузбасском кооперативном техникуме" по специальности "Специалист по информационным технологиям".</p>
        </div>
Corusel; 
        $resultTemplate = sprintf($template, $title, $content); 
        return $resultTemplate; 
    }
}

