<?php 

namespace App\Views;

use App\Views\BaseTemplate;

class ProductTemplate extends BaseTemplate
{
    public static function getCardTemplate($data): string
    {
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
                      </div>
                    </div>
                  </div>
                </div>';
        return $html;
    }
}
