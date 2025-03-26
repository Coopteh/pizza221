<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\ProductController;
use App\Models\Product;

$productController = new ProductController();
$productController->show(1);

$product = new Product('Laptop');
echo $product->getName();