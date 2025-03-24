<?php 
namespace App\Router;

use App\Controllers\AboutController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;

class Router {
    public function route(string $url): string {
        $path = parse_url($url, PHP_URL_PATH);
        $pieces = explode("/", $path);
        //var_dump($pieces);
        $resource = $pieces[2];
        switch ($resource) {
            case "about":
                $about = new AboutController();
                return $about->get();
            case "products":
                $productController = new ProductController();
                $id = (isset($pieces[3]) ) ? intval($pieces[3]) : null;
                return $productController->get($id);                
            default:
                $home = new HomeController();
                return $home->get();
                case "basket":
                    $basketController = new BasketController();
                    $basketController->add();
                    $prevUrl = $_SERVER['HTTP_REFERER'];
                    header("Location: {$prevUrl}");
                    switch ($route) {
                        case 'some_case':
                            header("Location: {$prevUrl}");
                            return "";
                            $prevUrl = $_SERVER['HTTP_REFERER'];
                hеader("Location: {$prevUrl}");                    
                return "";
                    }
        }
    }
}

