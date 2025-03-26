<?php 
namespace App\Router;

use App\Controllers\AboutController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\BasketController;
use App\Controllers\OrderController;

class Router {
    public function route(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $pieces = explode("/", trim($path));
        $resource = isset($pieces[2]) ? $pieces[2] : "";
//var_dump($pieces);    
        switch ($resource) {
            case "about":
                $about = new AboutController();
                return $about->get();
            case "order":
                $order = new OrderController();
                return $order->get(); 
            case 'basket_clear':
                $basketController = new BasketController();
                $basketController->clear();
                $prevUrl = $_SERVER['HTTP_REFERER'];
                header("Location: {$prevUrl}");
                return '';
            case "products":
                $productController = new ProductController();
                $id = (isset($pieces[3])) ? intval($pieces[3]) : null;
                return $productController->get($id);                
            case "basket":
                $basketController = new BasketController();
                $basketController->add();
                $prevUrl = $_SERVER['HTTP_REFERER'];
                header("Location: {$prevUrl}");                    
                return "";
            default:
                $home = new HomeController();
                return $home->get();
        }
    }
}