<?php

namespace App\Controllers;

use App\Views\ProductTemplate;
use App\Models\Product;

class ProductController{
    public function get(?int $id = null): string 
{
    $model = new Product();
    $data = $model->loadData();

    if (isset($data[$id-1])){
        $data = $data[$id-1];
    } else {
        return ProductTemplate::getAllTemplate($data);
    }
    
        return ProductTemplate::getCardTemplate($data);
}
}