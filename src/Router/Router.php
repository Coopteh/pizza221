<?php 

namespace App\Router;

use App\Controllers\HomeController;
use App\Controllers\AboutController;
use App\Controllers\ProductController;
use App\Controllers\BasketController;
use App\Controllers\OrderController;

class Router
{
    public function route(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $pieces = explode("/", trim($path));
        $pieces = array_filter($pieces);

        if (empty($pieces)) {
            $home = new HomeController();
            return $home->get();
        }

        // Check if the route exists
        if (isset($pieces[1])) {
            switch ($pieces[1]) {
                case "about":
                    $about = new AboutController();
                    return $about->get();

                case "products":
                    $productController = new ProductController();
                    $id = (isset($pieces[2]) && $pieces[2]) ? intval($pieces[2]) : null;
                    return $productController->get($id);
                
                case "basket":
                    $basketController = new BasketController();
                    $basketController->add();
                    $prevUrl = $_SERVER['HTTP_REFERER'];
                    header("Location: {$prevUrl}");
                    return "";
                
                case "basket_clear":
                    $basketController = new BasketController();
                    $basketController->clear();
                    $_SESSION['flash'] = "Корзина успешно очищена.";
                    $prevUrl = $_SERVER['HTTP_REFERER'];
                    header("Location: {$prevUrl}");
                    return "";
                
                case "order":
                    $orderController = new OrderController();
                    return $orderController->get();

                default:
                    $home = new HomeController();
                    return $home->get();
            }
        } else {
            $home = new HomeController();
            return $home->get();
        }
    }
}
