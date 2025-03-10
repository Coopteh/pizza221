<?php 
require_once("./vendor/autoload.php");

use App\Views\HomeTemplate;

$template = HomeTemplate::getTemplate();

echo $template;
