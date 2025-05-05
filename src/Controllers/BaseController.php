<?php
namespace App\Controllers;

use Exception;

class BaseController {
    protected function handleException(Exception $e, string $redirectUrl): void {
        $_SESSION['flash'] = "Ошибка: " . $e->getMessage();
        error_log("Controller error: " . $e->getMessage());
        header("Location: " . $redirectUrl);
        exit;
    }
}