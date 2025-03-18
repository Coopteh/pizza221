<?php 

namespace App\Controllers;

use App\Models\Product;
use App\Views\ProductTemplate;

class ProductController
{
    public function get(?int $id = null): string
{
    $model = new Product();
    $data = $model->loadData();
    if (!isset($id)) {
        return ProductTemplate::getAllTemplate($data);
    } else {
        $productIndex = $id - 1; 
        if (isset($data[$productIndex])) {
            return ProductTemplate::getCardTemplate($data[$productIndex]);
        } else {
            return "Продукт не найден";
        }
    }
}

}
