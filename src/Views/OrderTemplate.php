<?php
 $all_sum = 0;
 foreach ($products as $product) {
 $name = $product['name'];
         $price = $product['price'];
 $quantity = ..

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
         $content .= <<<LINE
         <div class="row">
             <div class="col-12">
             - нет добавленных товаров -
             </div>
         </div>
          <div class="row">
                    <div class="col-6">
                         
                    </div>
                    <div class="col-6 float-end">
                        <form action="/basket_clear" method="POST">
                        <button type="submit" class="btn btn-secondary mt-3">Очистить корзину
                        </form>
                    </div>
                </div>    
         LINE;
         
}