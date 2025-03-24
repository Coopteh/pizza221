<?php

namespace App\Controllers;

class BasketController
{
    public function add(): void {
        session_start();
        
        if (isset($_POST['id'])) {
            $product_id = $_POST['id'];
        
            if (!isset($_SESSION['basket'])) {
                $_SESSION['basket'] = [];
            }
        
            if (isset($_SESSION['basket'][$product_id])) {
                $_SESSION['basket'][$product_id]['quantity']++;
            } else {
                $_SESSION['basket'][$product_id] = [
                    'quantity' => 1
                ];
            }
        
            $_SESSION['flash'] = "Товар успешно добавлен в корзину!";
        }
        
        // Перенаправление обратно на предыдущую страницу
        $prevUrl = $_SERVER['HTTP_REFERER'];
        header("Location: {$prevUrl}");
        exit();
    }

    public function clear(): void {
        session_start();
        $_SESSION['basket'] = [];
        $_SESSION['flash'] = "Корзина успешно очищена.";
    }
    
}
