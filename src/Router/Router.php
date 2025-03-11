<?php

namespace App\Router;

use App\Controllers\AboutController;
use App\Controllers\HomeController;

class Router {
    public function route(string $url): ?string {
        $path = parse_url($url, PHP_URL_PATH);  // Получаем путь из URL
        $pieces = explode("/", $path);  // Разбиваем путь на части
        $resource = $pieces[2] ?? null; // Получаем название ресурса (если оно есть)

        switch ($resource) {
            case "about":
                $about = new AboutController();
                return $about->get();
                break;
            default:
                $home = new HomeController();
                return $home->get();
        }
    }
}