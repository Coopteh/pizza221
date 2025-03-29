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
            <h3>Корзина</h1>
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
                                        <button type="submit" class="btn btn-secondary mt-3">Очистить корзину </button>
                                    </form>
                                </div>
                            </div> 

                       <form action="/pizza221/order" method="POST">
                            <div class="mb-3">
                                <label for="fioInput" class="form-label">ФИО</label>
                                <input type="text" name = "fio" class="form-control" id="fioInput">
                            </div> 
                            <div class="mb-3">
                            <label for="emailInput" class="form-label">Имейл адрес</label>
                            <input type="text" name = "email" class="form-control" id="emaillInput">
                            </div>
                            <div class="mb-3">
                            <label for="phoneInput" class="form-label">Телефон</label>
                            <input type="text" name = "phone" class="form-control" id="phoneInput">
                            </div> 
                                <div class="mb-3">
                            <label for="addressInput" class="form-label">Адрес</label>
                            <input type="text" name = "address" class="form-control" id="addressInput">
                            </div> 
                            <div class="mb-3">
                            <button type="submit" class="btn btn-secondary mt-3">Создать заказ</button>
                        </form>
                </div>

            LINE;
        }

        $content .= "</main>";

        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
        
    }

}