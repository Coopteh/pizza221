<?php

namespace App\Views;
use App\Views\BaseTemplate;

class ProductTemplate extends BaseTemplate
{
    public static function getCardTemplate(array $data) {
        $template = parent::getTemplate();
        $title = 'Каталог';
        $content = <<<HTML
    
        <div class="card mb-3" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4 mt-3">
      <img src="{$data['image']}" class="img-fluid rounded-start" alt="{$data['name']}">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">{$data['name']}</h5>
        <p class="card-text">{$data['description']}</p>
        <h5 class="card-title"><strong>Цена: </strong>{$data['price']} руб.</h5>
        <form class="mt-4" action="/basket" method="POST">
          <input type="hidden" name="id" value="{$data['id']}">
          <button type="submit" class="btn btn-primary">Добавить в корзину</button>
        </form>
      </div>
    </div>
  </div>
</div>
        <br><h1><b><strong><u><i>Продукт</i></u></strong></b></h1></br>
HTML;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }

    public static function getAllTemplate(array $arr): string 
    {
        $template = parent::getTemplate();
        $str= '<div class="row">';;

        // для каждого товара
        foreach( $arr as $key => $item ) {

          $element_template = <<<HTML
<div class="card" style="width: 18rem; margin: 30px;">
    <img src="{$item['image']}" class="card-img-top" alt="{$item['name']}">
    <div class="card-body">
        <a href="http://localhost/products/{$item['id']}"><h5 class="card-title">{$item['name']}</h5></a>
        <p class="card-text">{$item['description']}</p>
        <h5 class="card-title"><strong>Цена: </strong>{$item['price']} руб.</h5>
        <form class="mt-4" action="/basket" method="POST">
          <input type="hidden" name="id" value="{$item['id']}">
          <button type="submit" class="btn btn-primary">Добавить в корзину</button>
        </form>
    </div>
</div>
HTML;

            $str.= $element_template;
        }
        $str.= "</div>";
        $resultTemplate = sprintf($template, 'Каталог продукции', $str);
        return $resultTemplate;
    }
}