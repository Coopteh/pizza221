<?php

namespace App\Controllers;

class BasketController
{
    public function add(): void
    {

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
            //exit();
            $_SESSION['flash'] = "Товар успешно добавлен в корзину!";
        }
    }
    /*
    Очистка корзины
    */
    public function clear(): void
    {
        $_SESSION['basket'] = [];
        $_SESSION['flash'] = "Корзина успешно очищена.";
    }
}