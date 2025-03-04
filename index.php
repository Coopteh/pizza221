<?php

require_once "./vendor/autoload.php";

use App\Views\BaseTemplate; 

$template = BaseTemplate::getTemplate();
$resultTemplate = sprintf($template, "Основная страница", "<h1><b><strong><u><i>САМАЯ ЛУЧШАЯ ПИЦЦА, НА ТРАДИЦИОННОМ ТЕСТЕ!!!</i></u></strong></b></h1>");
echo $resultTemplate;
