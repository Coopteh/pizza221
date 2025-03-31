<?php 
namespace App\Controllers;

use App\Views\AboutTemplate;

class AboutController {
    public function get(): string {
        return AboutTemplate::getTemplate();
    }
}
