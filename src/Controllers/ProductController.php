<?php

namespace App\Controllers;

use App\Views\ProductTemplate;
use App\Models\Product;

class ProductController{
    public function get($id): string 
{
    $model = new Product();
    $data = $model->loadData();
    if ($id)
        $data = $data[$id-1];
    return ProductTemplate::getCardTemplate($data);
}
}