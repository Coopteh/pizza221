<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class AboutTemplate extends BaseTemplate
{
    public static function getTemplate(): string {
        $template = parent::getTemplate();
        $title= 'О нас';
        $content = <<<CORUSEL
        <main class="row p-5">
            <h1>О нас</h1>
            <p>Студенты группы ИС-221 в рамках обучения в "Кузбасском кооперативном техникуме", по специальности "Специалист по информационным технологиям", создали сайт пиццерии.</p>
        </main>        
        CORUSEL;
        
        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }
}
