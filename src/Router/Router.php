<?php

namespace App\Router;

use App\Controllers\AboutController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\BasketController;

class Router{
    public function route(string $url): string{
        $path = parse_url($url, PHP_URL_PATH);  // /about
        $pieces = explode("/", $path);  // [0]- пусто, [1]- about
        $resource = $pieces[1];
        switch ($resource) {
            case "about":
                $about = new AboutController();
                return $about->get();

            default:
                $home = new HomeController();
                return $home->get();

            case "product":
                $product = new ProductController();
                $id = isset($pieces[2]) ? intval($pieces[2]) : null;
                return $product->get($id);
                case "basket":
                    $basketController = new BasketController();
                    $basketController->add();
                    $prevUrl = $_SERVER['HTTP_REFERER'];
                    header("Location: {$prevUrl}");
            }
        
    }
    
}
