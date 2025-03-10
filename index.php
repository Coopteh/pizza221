<?php

require_once "./vendor/autoload.php";

use App\Views\BaseTemplate; 
use App\Controllers\HomeController;

$controller = new HomeController();
echo $controller->get();
