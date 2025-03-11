<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class AboutTemplate extends BaseTemplate {
    
    public static function getTemplate(): string {
        $template = parent::getTemplate();
        $title = 'О нашем техникуме';
        $content = <<<HTML
        <section>        
            <div class="h-100 w-100 mx-auto">  
                <img src="./assets/images/image4.png" class="img-fluid" alt="...">
            </div>
        </section>
        <main class="row">
            <div class="p-5">
                <h1>О нашем техникуме</h1>
                <p>Кемеровский кооперативный техникум сегодня – это первый шаг на пути к будущей успешной карьере. </p>
                <p>Кемеровский кооперативный техникум был основан в 1974 году в связи с потребностью в специалистах для предприятий и организаций потребительской кооперации Кемеровской области. И сегодня Кемеровский кооперативный техникум готовит специалистов по самым престижным и востребованным специальностям.</p>
                <p>Наши преподаватели - это опытные профессионалы, которые делятся своими знаниями и опытом. Мы используем современные образовательные технологии и программы.</p>
            </div>
        </main>
HTML;

        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }
}