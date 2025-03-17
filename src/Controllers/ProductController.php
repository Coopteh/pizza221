<?php 

namespace App\Controllers;

use App\Models\Product;
use App\Views\ProductTemplate;

class ProductController
{
    public function get($id): string
    {
        $model = new Product();
        $data = $model->loadData();
        if ($id) {
            $data = $data[$id - 1]; 
        } else {
            return "Продукт не найден";
        }
        return ProductTemplate::getCardTemplate($data);
    }
}