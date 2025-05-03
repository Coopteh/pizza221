<?php

namespace App\Views;

use App\Views\BaseTemplate;

class OrderTemplate extends BaseTemplate {
    public static function getOrderTemplate(array $arr): string {
        $template = parent::getTemplate();
        $title = 'заказ';
        $content = '<h1 class="mb-5">Создание заказа</h1><h3>Корзина</h3>';
        $all_sum = 0;

        if (empty($arr)) {
            $content .= <<<HTML
            <div class="row">
                <div class="col-12">
                    - нет добавленных товаров -
                </div>
            </div>
            HTML;
        } else {
            foreach ($arr as $product) {
                $name = $product['name'];
                $price = $product['price'];
                $quantity = $product['quantity'];
                $sum = $product['sum'];
                $all_sum += $sum;

                $content .= <<<HTML
                <div class="row">
                    <div class="col-6">{$name}</div>
                    <div class="col-2">{$quantity} ед. x {$price} руб.</div>
                    <div class="col-2">{$sum} ₽</div>
                </div>
                HTML;
            }
        }

        // Итоговая сумма
        if ($all_sum > 0) {
            $content .= <<<HTML
            <div class="row">
                <div class="col-6">Итого:</div>
                <div class="col-2">{$all_sum} ₽</div>
            </div>
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6 float-end">
                    <form action="/pizza221/basket_clear" method="POST">
                        <button type="submit" class="btn btn-secondary mt-3">Очистить корзину</button>
                    </form>
                </div>
            </div>
            HTML;
        }

        // Добавление формы для создания заказа
        $content .= <<<HTML
        <h3 class="mt-5">Форма для создания заказа</h3>
        <form action="/pizza221/order" method="POST">
            
            <div class="form-group">
                <label for="fio">Ваше ФИО:</label>
                <input type="text" class="form-control" id="fio" name="fio" required>
            </div>
            <div class="form-group">
                <label for="address">Адрес доставки:</label>
                <input type="text" class="form-control" id="address" name="address" required>

            </div>

            <div class="form-group">
                <label for="address">Адрес почты:</label>
                <input type="text" class="form-control" id="email" name="email" required>

            </div>

            <div class="form-group">
                <label for="phone">Телефон:</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Создать заказ</button>
        </form>
        HTML;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}