<?php 
namespace App\Views;

class OrderTemplate extends BaseTemplate
{
    public static function getOrderTemplate(array $products): string
    {
        $template = parent::getTemplate();
        $title = 'Создание заказа';

        $content = '<h1 class="mb-5">Создание заказа</h1>';
        $content .= '<h3>Корзина</h3>';

        $all_sum = 0;
        foreach ($products as $product) {
            $name = $product['name'];
            $price = $product['price'];
            $quantity = $product['quantity'];

            $sum = $price * $quantity;
            $all_sum += $sum;

            $content .= <<<LINE
            <div class="row">
                <div class="col-6">
                    {$name}
                </div>
                <div class="col-2">
                    {$quantity} ед. x {$price} руб.
                </div>
                <div class="col-2">
                    {$sum} ₽
                </div>
            </div>
            LINE;
        }

        if ($all_sum > 0) {
            $content .= <<<LINE
            <div class="row">
                <div class="col-12">
                    Итого: {$all_sum} ₽
                </div>
            </div>
            LINE;
        } else {
            $content .= <<<LINE
            <div class="row">
                <div class="col-12">
                    - нет добавленных товаров -
                </div>
            </div>
            LINE;
        }

        $content .= <<<LINE
        <div class="row">
            <div class="col-6">
            </div>
            <div class="col-6 float-end">
                <form action="/pizza221/basket_clear" method="POST">
                    <button type="submit" class="btn btn-secondary mt-3">Очистить корзину</button>
                </form>
            </div>
        </div>
        LINE;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}
