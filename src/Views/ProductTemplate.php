<?php 

namespace App\Views;

use App\Views\BaseTemplate;

class ProductTemplate extends BaseTemplate
{
    public static function getCardTemplate($data): string
    {
        $template = parent::getTemplate();
        $title = $data['name'];
        $html = '<div class="card mb-3" style="max-width: 540px;">
                  <div class="row g-0">
                    <div class="col-md-4">
                      <img src="' . $data['image'] . '" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                      <div class="card-body">
                        <h5 class="card-title">' . $data['name'] . '</h5>
                        <p class="card-text">' . $data['description'] . '</p>
                        <p class="card-text"><small class="text-muted">Цена: ' . $data['price'] . ' руб.</small></p>
                        /*  <form class="mt-4" action="/pizza221/basket" method="POST">
                            <input type="hidden" name="id" value="{$rec['id']}">
                        */      <button type="submit" class="btn btn-primary">Добавить в корзину</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>';
        $resultTemplate = sprintf($template, $title, $html);
        return $resultTemplate;

    } 
    public static function getAllTemplate(array $arr): string {
        $template = parent::getTemplate();
        $str= '<div class="container">';

        // для каждого товара
        foreach( $arr as $key => $item ) {

            $element_template= <<<END
            <div class="row mb-5">
                <div class="col-6">
                    <img src="{$item['image']}" class="w-100">
                </div>
                <div class="col-6">
                    <div class="block mt-3">
                        <a href="/pizza221/products/{$item['id']}"><h2>{$item['name']}</h2></a>
                        <p>{$item['description']}</p>
                        <h3>{$item['price']} ₽</h3>
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