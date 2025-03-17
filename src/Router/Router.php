<?php

namespace App\Router;

use App\Controllers\AboutController;
use App\Controllers\HomeController;

class Router {
    public function route(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $pieces = explode('/', $path);
        $resource = $pieces[1];
    
        switch ($resource) {
            case "product":
                $product = new ProductController();
                $id = isset($pieces[2]) ? intval($pieces[2]) : 0;
                return $product->get($id);
            // Другие маршруты...
        }
    }
}