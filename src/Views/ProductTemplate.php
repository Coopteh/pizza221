<?php

namespace App\Views;
use App\Views\BaseTemplate;

class ProductTemplate extends BaseTemplate
{
    public static function getCardTemplate(array $data) {
        $template = parent::getTemplate();
        $title = 'Главная страница';
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
      </div>
    </div>
  </div>
</div>
        <br><h1><b><strong><u><i>САМАЯ ЛУЧШАЯ ПИЦЦА, НА ТРАДИЦИОННОМ ТЕСТЕ!!!</i></u></strong></b></h1></br>
HTML;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}