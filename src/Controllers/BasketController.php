<?php

namespace App\Controllers;

class BasketController
{
    public function add(): void
    {
        // Проверка, инициализирована ли сессия
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_POST['id'])) {
            $product_id = intval($_POST['id']); // Приведение к целому числу для безопасности

            // Инициализация корзины, если она еще не существует
            if (!isset($_SESSION['basket'])) {
                $_SESSION['basket'] = [];
            }

            // Добавление товара в корзину
            if (isset($_SESSION['basket'][$product_id])) {
                $_SESSION['basket'][$product_id]['quantity']++;
            } else {
                $_SESSION['basket'][$product_id] = [
                    'quantity' => 1
                ];
            }

            $_SESSION['flash'] = "Товар успешно добавлен в корзину!";
        } else {
            $_SESSION['flash'] = "Ошибка: ID товара не указан.";
        }
    }

    /*
    Очистка корзины
    */
    public function clear(): void
    {
        // Проверка, инициализирована ли сессия
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['basket'] = [];
        $_SESSION['flash'] = "Корзина успешно очищена.";
    }
}