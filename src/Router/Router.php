<?php 
namespace App\Router;

use App\Controllers\AboutController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\BasketController;
use App\Controllers\OrderController;

class Router {
    public function route(string $url): string {
        $path = parse_url($url, PHP_URL_PATH);
        $pieces = explode("/", $path);
        //var_dump($pieces);
        $resource = $pieces[1];
        switch ($resource) {
            case "about":
                $about = new AboutController();
                return $about->get();
            case "products":
                $products = new ProductController();
                $id = isset(($pieces[2])) ? intval($pieces[2]) : null;
                return $products->get($id);    
            case "basket":
                $basketController = new BasketController();
                $basketController->add();
                $prevUrl = $_SERVER['HTTP_REFERER'];
                header("Location: {$prevUrl}"); 
                return "";  
            case 'order':
                $order = new OrderController();
                return $order->get();
            case "basket_clear":
                $basketController = new BasketController();
                $basketController->clear(); // Очищаем корзину
                $prevUrl = $_SERVER['HTTP_REFERER']; // Возвращаемся на предыдущую страницу
                header("Location: {$prevUrl}");
                return ""; // Возвращаем пустую строку   
            default:
                $home = new HomeController();
                return $home->get();
        }
    }
}