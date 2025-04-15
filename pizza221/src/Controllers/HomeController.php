<?php

namespace App\Controllers;

use App\Views\HomeTemplate;

class HomeController {

    public function get(): string {
        // Создаем экземпляр HomeTemplate и вызываем метод getTemplate
        return HomeTemplate::getTemplate();
    }
}