<?php

namespace App\Controllers;

use App\Views\AboutTemplate;

class BasketController {
    public function add():void {
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
        //var_dump($_SESSION);
            $_SESSION['flash'] = "Товар успешно добавлен в корзину!"; 
        //exit();
        }
    }
    /* 
    Очистка корзины
    */
    public function clear():void {
        session_start();
        $_SESSION['basket'] = []; // Очищаем корзину
        $_SESSION['flash'] = "Корзина успешно очищена."; // Уведомление пользователю
    }
}