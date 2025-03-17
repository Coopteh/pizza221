<?php

namespace App\Controllers;

use App\Models\Product;
use App\Views\ProductTemplate;

class ProductController {
    public function get(int $id = null): string {
        $model = new Product();
        $data = $model->loadData();

        if (isset($data[$id-1])) {
            $data = $data[$id-1];
        } else {
            // Если товар с таким ID не найден, можно вернуть ошибку или пустые данные
            $data = [];
        }
        
        return ProductTemplate::getCardTemplate($data);
    }
}
?>