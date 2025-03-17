<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class ProductTemplate extends BaseTemplate
{
    public static function getCardTemplate(?array $rec): string {
        $template = parent::getTemplate();
        if ($rec) {
            $title= "Карточка для {$rec['name']}";
            $content = <<<CORUSEL
            <main class="row p-5">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4 mt-3">
                        <img src="{$rec['image']}" class="img-fluid rounded-start" alt="Изображение пиццы">
                        </div>
                        <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{$rec['name']}</h5>
                            <p class="card-text">{$rec['description']}</p>
                            <p class="card-text"><strong class="text-body-primary">{$rec['price']} руб.</strong></p>
                        </div>
                        </div>
                    </div>
                </div>
            </main>        
            CORUSEL;
        } else {
            $title= "404 ошибка";
            $content = <<<CORUSEL
            <main class="row p-5">
                <p>404 Ой-еей(( Страница не найдена</p>
            </main>
            CORUSEL;
        }
        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }
}
