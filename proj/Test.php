<?php
require_once 'App/Models/User.php';
require_once 'App/Controllers/User.php';

use App\Models\User as ModelUser;
use App\Controllers\User as ControllerUser;

$modelUser = new ModelUser();
$controllerUser = new ControllerUser();

echo $modelUser->getUserData() . "</br>";
echo $controllerUser->getUserData() . "</br>";