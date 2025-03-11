<?php 
namespace App\Router;

use App\Controllers\AboutController;
use App\Controllers\HomeController;

Class Router {
    public function route(string $url): string {
        $path = parse_url($url, PHP_URL_PATH);  // /about
        $pieces = explode("/", $path);  // [0]- пусто, [1]- pizza221, [2]- about
        $resource = $pieces[2] ?? '';
        switch ($resource) {
            case "about":
                $about = new AboutController();
                return $about->get();
            default:
                $home = new HomeController();
                return $home->get();
        }
    }
}