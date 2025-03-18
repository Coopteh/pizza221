<?php

namespace App\Views;
use App\Views\BaseTemplate;


class ProductTemplate extends BaseTemplate
{
    public static function getCardTemplate(array $data) {
        $template = parent::getTemplate();
        $title = ' Каталог';
        $content = <<<HTML


        



        <div class="card mb-3" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="{$data['image']}" class="img-fluid rounded-start" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">{$data['name']}</h5>
        <p class="card-text">{$data['description']}</p>
        <p class="card-text"><small class="text-body-secondary">Цена: {$data['price']}руб.</small></p>
      </div>
    </div>
  </div>
</div>



        
HTML;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
    public static function getAllTemplate(array $arr): string 
    {
        $template = parent::getTemplate();
        $str= '<div class="container">';

        // для каждого товара
        foreach( $arr as $key => $item ) {

            $element_template= <<<HTML
            <div class="row mb-5">
                <div class="col-6">
                    <img src="{$item['image']}" class="w-50" >
                </div>
                <div class="col-6">
                    <div class="block mt-3" >
                        <a href="http://localhost/products/{$item['id']}"><h2>{$item['name']}</h2></a>
                        <p>{$item['description']}</p>
                        <h3>{$item['price']} ₽</h3>
                        <button>Добавить в корзину</button>
                    </div>
                </div>
                <hr>
            </div>
            HTML;

            $str.= $element_template;
        }
        $str.= "</div>";
        $resultTemplate = sprintf($template, 'Каталог продукции', $str);
        return $resultTemplate;
    }
}
