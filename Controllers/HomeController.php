<?php
namespace Controllers;

use Views\HomeTemplate;

class HomeController {
    public function get(): string {
        return HomeTemplate::getTemplate();
    }
}
?>