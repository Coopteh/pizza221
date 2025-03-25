<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class OrderTemplate extends BaseTemplate
{
    public static function getOrderTemplate(array $products): string {
        $template = parent::getTemplate();
        $title= 'Создание заказа';
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
    
        // Добавляем форму для ввода данных о доставке
        $content .= <<<FORM
            <h3 class="mt-5">Данные для доставки</h3>
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
                    <label for="phone">Телефон:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Создать заказ</button>
            </form>
        FORM;
    
        $content .= "</main>";
    
        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }
}
