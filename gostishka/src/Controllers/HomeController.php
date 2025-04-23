<?php 
namespace App\Controllers;

use App\Views\HomeTemplate;

class HomeController {
    public function get(): string {
        return HomeTemplate::getTemplate();
    }
}
