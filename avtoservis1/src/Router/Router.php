<?php

namespace App\Router;

use App\Controllers\AboutController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;

class Router {
    public function route(string $url): string {
        $path = parse_url($url, PHP_URL_PATH);
        $pieces = explode("/", $path);
        $resource = $pieces[2];
        switch ($resource) {
            case "about":
                $about = new AboutController();
                return $about->get();
                
            case "products":
                $products = new ProductController();
                $id = isset($pieces[3]) ? intval($pieces[3]) : null; // Изменено на null
                return $products->get($id);
            default:
                $home = new HomeController();
                return $home->get();
        }
    }
}