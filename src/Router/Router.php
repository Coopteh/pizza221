<?php

namespace App\Router;

use App\Controllers\AboutController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\BasketController;
use App\Controllers\OrderController;
use App\Controllers\RegisterController;

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
            case "basket":
                $basketController = new BasketController();
                $basketController->add();
                $prevUrl = $_SERVER['HTTP_REFERER'];
                header("Location: {$prevUrl}");
                return "";
            case 'order':
                $controller = new OrderController();
                return $controller->get();
            case "register":
                $registerController = new RegisterController();
                return $registerController->get();
            case "verify":
                if (isset($pieces[3])) { // Проверяем, передан ли токен
                    $token = $pieces[3];
                    $registerController = new RegisterController();
                    return $registerController->verify($token);
                }
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