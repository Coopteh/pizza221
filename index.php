<?php

require_once './vendor/autoload.php'; 

use App\Controllers\HomeController;
use App\Views\BaseTemplate;
use App\Router\Router;

$router = new Router();
$url = $_SERVER['REQUEST_URI'];
echo $router->route($url);
