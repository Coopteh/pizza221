<?php 

namespace App\Views;

use App\Views\BaseTemplate;

class ProductTemplate extends BaseTemplate
{
  public static function getAlltemplate(array $arr): string
  {
      $template = parent::getTemplate();
      $str = '<div class="container">';
  
      foreach ($arr as $key => $item) {
          $element_template = <<<END
          <div class="row mb-5">
              <div class="col-6">
                  <img src="{$item['image']}" class="w-100">
              </div>
              <div class="col-6">
                  <div class="block mt-3">
                      <a href="/pizza221/products/{$item['id']}"><h2>{$item['name']}</h2></a>
                      <p>{$item['description']}</p>
                      <h3>{$item['price']} ₽</h3>
                  </div>
              </div>
              <hr>
          </div>
          END;
  
          $str .= $element_template;
      }
      $str .= "</div>";
      $resultTemplate = sprintf($template, 'Каталог продукции', $str);
      return $resultTemplate;
  }
  
}

