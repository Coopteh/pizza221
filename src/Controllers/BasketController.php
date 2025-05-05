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
    public function getTotal() {
        $total = 0;
        foreach ($_SESSION['basket'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Применяем скидку если есть
        if (isset($_SESSION['discount'])) {
            $discountText = $_SESSION['discount'];
            if (strpos($discountText, '%') !== false) {
                $percent = (float)str_replace('% скидки', '', $discountText);
                $total *= (1 - $percent/100);
            } elseif ($discountText === "Бесплатная доставка") {
                $total -= 500; // Пример стоимости доставки
            }
        }
        
        return $total;
    }
    public function showDiscountButton(): string{
        return '<button id="show-wheel">Получить скидку!</button>';
    }
    
}