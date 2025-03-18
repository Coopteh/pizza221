<?php
namespace App\Controllers;
use App\Views\ProductTemplate;
use App\Models\Product;
class ProductController{
    public function get(?int $id = null): string 
{
    $model = new Product();
    $data = $model->loadData();
    if (!isset($id))
        $data = $data;
        return ProductTemplate::getAllTemplate($data);
}

}
