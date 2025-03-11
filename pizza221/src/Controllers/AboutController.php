<?php 
namespace App\Controllers;

use App\Views\AboutTemplate;

Class AboutController {
    public function get(): string {
        return AboutTemplate::getTemplate();
    }
}