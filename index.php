<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Router\Router;
//use App\Views\BaseTemplate; 
//use App\Controllers\HomeController;

$router = new Router();
//$controller = new HomeController();
$url = $_SERVER['REQUEST_URI']; 
echo $router->route($url);
//echo $controller->get();