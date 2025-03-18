<?php
namespace App\Views;
use App\Views\BaseTemplate;

class ProductTemplate extends BaseTemplate {
    public static function getCardTemplate(?array $data) {
      $template = parent::getTemplate();
      if ($data) {
        $title = $data['name'];

        $content = <<<HTML
            <main class="row p-5">
               <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4 mt-3">
                        <img src="{$data['image']}" class="img-fluid rounded-start" alt="Изображение пиццы">
                        </div>
                        <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{$data['name']}</h5>
                            <p class="card-text">{$data['description']}</p>
                            <p class="card-text"><strong class="text-body-primary">{$data['price']} руб.</strong></p>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </main>        
            HTML;
        } else {
          $title= "404 ошибка";
          $content = <<<HTML
          <main class="row p-5">
              <p>404 ошибка <br>
              Страница не найдена</p>
          </main>
          HTML;
        }
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
    public static function getAllTemplate(array $arr): string {
      $template = parent::getTemplate();
      $str = '<div class="container">';

      // Для каждого товара
      foreach ($arr as $key => $item) {
          $element_template = <<<HTML
                  <div class="col-6 col-md-4 mb-4"> <!-- Изменено на col-6 для мобильных и col-md-4 для средних экранов -->
            <div class="card">
                <img src="{$item['image']}" class="card-img-top" alt="{$item['name']}">
                <div class="card-body">
                    <h5 class="card-title"><a href="/pizza221/products/{$item['id']}">{$item['name']}</a></h5>
                    <p class="card-text">{$item['description']}</p>
                    <h6 class="card-price">{$item['price']} ₽</h6>
                </div>
            </div>
          </div>
          HTML;

          $str .= $element_template;
      }
      $str .= "</div></div>";
      $resultTemplate = sprintf($template, 'Каталог продукции', $str);
      return $resultTemplate;
  }
}

