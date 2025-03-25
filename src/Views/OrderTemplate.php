<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class OrderTemplate extends BaseTemplate
{
    public static function getOrderTemplate(array $products): string {
        $template = parent::getTemplate();
        $title = 'Создание заказа';
        $content = <<<CORUSEL
        <main class="row p-5">
            <h1 class="mb-5">Создание заказа</h1>
            <h3>Корзина</h3>
        CORUSEL;

        $all_sum = 0;
        foreach ($products as $product) {
            $name = $product['name'];
            $price = $product['price'];
            $quantity = $product['quantity'];

            $sum = $price * $quantity;
            $all_sum += $sum;

            $content .= <<<LINE
                <div class="row">
                    <div class="col-5">
                        {$name}
                    </div>
                    <div class="col-3">
                        {$quantity} ед. x {$price} руб.
                    </div>
                    <div class="col-2">
                        {$sum} ₽
                    </div>
                </div>
            LINE;
        }

        if ($all_sum == 0) {
            $content .= <<<LINE
            <div class="row">
                <div class="col-12">
                    - нет добавленных товаров -
                </div>
            </div>
            LINE;
        } else {
            $content .= <<<LINE
                <div class="row">
                    <hr>
                    <div class="col-5">
                        <strong>Общая сумма:</strong>
                    </div>
                    <div class="col-3">
                        &nbsp;
                    </div>
                    <div class="col-2">
                        <strong>{$all_sum} ₽</strong>
                    </div>
                </div>    

                <div class="row">
                    <div class="col-8">
                        &nbsp;
                    </div>
                    <div class="col-2 float-end">
                        <form action="/pizza221/basket_clear" method="POST">
                            <button type="submit" class="btn btn-secondary mt-3">Очистить корзину</button>
                        </form>
                    </div>
                </div>    

            LINE;
        }

        // Форма для ввода данных покупателя
        $content .= <<<FORM
            <div class="row mt-5">
                <div class="col-12">
                    <h3>Данные для доставки:</h3>
                    <form action="/order" method="POST">
                        <div class="form-group">
                            <label for="fio">Ваше ФИО:</label>
                            <input type="text" name="fio" class="form-control" id="fio" placeholder="Введите ФИО">
                        </div>
                        <div class="form-group">
                            <label for="address">Адрес доставки:</label>
                            <input type="text" name="address" class="form-control" id="address" placeholder="Введите адрес">
                        </div>
                        <div class="form-group">
                            <label for="phone">Телефон:</label>
                            <input type="text" name="phone" class="form-control" id="phone" placeholder="Введите телефон">
                        </div>
                        <button type="submit" class="btn btn-primary">Создать заказ</button>
                    </form>
                </div>
            </div>
        FORM;

        $content .= "</main>";

        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }
}
