<?php
use Routers\Router;

require_once("./vendor/autoload.php");

$router = new Router();
$url = $_SERVER['REQUEST_URI'];

echo $router->route($url);
