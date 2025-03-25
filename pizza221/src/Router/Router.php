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
        if (empty($pieces[2])) {
            $home = new HomeController();
            return $home->get();
        }
        $resource = $pieces[2];
        switch ($resource) {
            case "about":
                $about = new AboutController();
                return $about->get();
            case "order":
                $orderController = new OrderController();
                try {
                    return $orderController->get();
                } catch (\Exception $e) {
                    error_log($e->getMessage());
                    return 'Error occurred. Please try again later.';
                }
            case 'basket_clear':
                $basketController = new BasketController();
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $prevUrl = $_SERVER['HTTP_REFERER'];
                } else {
                    $prevUrl = '/';
                }
                try {
                    $basketController->clear();
                } catch (\Exception $e) {
                    error_log($e->getMessage());
                    return 'Error occurred. Please try again later.';
                }
                header("Location: {$prevUrl}");
                return '';
            case "products":
                $productController = new ProductController();
                $id = (isset($pieces[3])) ? intval($pieces[3]) : null;
                try {
                    return $productController->get($id);
                } catch (\Exception $e) {
                    error_log($e->getMessage());
                    return 'Error occurred. Please try again later.';
                }
            case "basket":
                $basketController = new BasketController();
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $prevUrl = $_SERVER['HTTP_REFERER'];
                } else {
                    $prevUrl = '/';
                }
                try {
                    $basketController->add();
                } catch (\Exception $e) {
                    error_log($e->getMessage());
                    return 'Error occurred. Please try again later.';
                }
                header("Location: {$prevUrl}");
                return "";
            default:
                $home = new HomeController();
                return $home->get();
        }
    }
}