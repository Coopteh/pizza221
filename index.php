<?php 

require_once  "./vendor/autoload.php";

use App\Router\Router;

// Обновляем глобальные переменные - данными из сессии
$user_id=0; $username= "";
session_start();
if (isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];

$router = new Router();
$url = $_SERVER['REQUEST_URI'];
echo $router->route($url);
