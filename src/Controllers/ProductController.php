<?php 
namespace App\Controllers;

use App\Models\Product;
use App\Views\ProductTemplate;

class ProductController {
    public function get(int $id): string {
        $model= new Product();
        $data = $model->loadData();
        if (!isset($id))
            return ProductTemplate::getAllTemplate($data);

        if (($id) && ($id <= count($data))) {
            $record= $data[$id-1];
            return ProductTemplate::getCardTemplate($record);
        } else
            return ProductTemplate::getCardTemplate(null);
    }
}
