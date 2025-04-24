<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class OrderTemplate extends BaseTemplate
{
    /*
        Формирование страница ""Создание заказа"
    */
    public static function getOrderTemplate(?array $products, float $all_sum): string {
        $template = parent::getTemplate();
        $title= 'Создание заказа';
        $content = <<<CORUSEL
        <main class="row p-5">
            <h1 class="mb-5">Создание заказа</h1>
            <h3>Список товаров (Корзина)</h1>
        CORUSEL;
        $content .= self::getProductList($products);
        $content .= self::getSummaryInfo($all_sum);
        $content .= "</main>";

        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }

    /*
        Отображение списка товаров заказа (товаров в корзине)
    */
    public static function getProductList(?array $products): string {
        $content= '';
        foreach ($products as $product) {
		    $name = $product['name'];
            $price = $product['price'];
		    $quantity = $product['quantity'];

            $sum = $price * $quantity;

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
        return $content;
    }
    /*
        Общие итоги под списком товаров заказа 
        (сумма заказа, кнопка очистки корзины)
    */
    public static function getSummaryInfo(int $all_sum): string 
    {
        $content= '';
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
                        <form action="/gostishka/basket_clear" method="POST">
                            <button type="submit" class="btn btn-secondary mt-3">Очистить корзину
                        </form>
                    </div>
                </div>    
            LINE;

            $content .= self::getFormUserInformation();
        }
        return $content;
    }

    /* 
        Форма для сбора данных от пользователя 
        для доставки (телефон, адрес,..)
    */
    public static function getFormUserInformation(): string {
        $html= <<<FORMA
                <h3>Данные для доставки</h1>
                <form action="/gostishka/order" method="POST">
                    <div class="mb-3">
                        <label for="fioInput" class="form-label">Ваше имя (ФИО):</label>
                        <input type="text" name="fio" class="form-control" id="fioInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="addressInput" class="form-label">Адрес доставки:</label>
                        <input type="text" name="address" class="form-control" id="addressInput">
                    </div>
                    <div class="mb-3">
                        <label for="phoneInput" class="form-label">Телефон:</label>
                        <input type="text" name="phone" class="form-control" id="phoneInput">
                    </div>
                    <div class="mb-3">
                        <label for="emailInput" class="form-label">Емайл:</label>
                        <input type="email" name="email" class="form-control" id="emailInput">
                    </div>                    
                    <button type="submit" class="btn btn-primary">Создать заказ</button>
                </form>
        FORMA;
        return $html;
    }
}
