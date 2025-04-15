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
                            <h2 class="card-title">{$rec['name']}</h2>
                            <p class="card-text">{$rec['description']}</p>
                            <h3>{$rec['price']} руб.</h3>
                            <form class="mt-4" action="/pizza221/basket" method="POST">
                                <input type="hidden" name="id" value="{$rec['id']}">
                                <button type="submit" class="btn btn-primary">Добавить в корзину</button>
                            </form>
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

    public static function getAllTemplate(array $arr): string 
    {
        $template = parent::getTemplate();
        $str= '<div class="container">';

        // для каждого товара
        foreach( $arr as $key => $item ) {

            $element_template= <<<END
            <div class="row mb-5">
                <div class="col-6">
                    <img src="https://habrastorage.org/webt/65/25/15/65251536a7ad4387085522.png" class="w-100">
                </div>
                <div class="col-6">
                    <div class="block mt-3">
                        <a href="/pizza221/products/{$item['id']}"><h2>Покупка ПК</h2></a>

                        <h3>100000 ₽</h3>
                        <form class="mt-4" action="/pizza221/basket" method="POST">
                            <input type="hidden" name="id" value="{$item['id']}">
                            <button type="submit" class="btn btn-primary">Добавить в корзину</button>
                        </form>
                    </div>
                </div>
                <hr>
            </div>
            END;

            $str.= $element_template;
        }
        $str.= "</div>";
        $resultTemplate = sprintf($template, 'Каталог продукции', $str);
        return $resultTemplate;
    }
}