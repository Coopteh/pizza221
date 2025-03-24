<?php
namespace App\Views;

class OrderTemplate {
    public static function getOrderTemplate(array $arr): string {
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
                    <form action="/basket_clear" method="POST">
                        <button type="submit" class="btn btn-secondary mt-3">Очистить корзину</button>
                    </form>
                </div>
            </div>
            HTML;
        }
        // Возвращаем сгенерированный контент
        return $content; // Убедитесь, что здесь есть return
    }
}