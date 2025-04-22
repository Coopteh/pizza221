<?php 
namespace App\Controllers;

use App\Views\OrderTemplate;
use App\Models\Product;
use App\Models\Order;
use App\Services\FileStorage;
use App\Services\ProductDBStorage;
use App\Services\OrderDBStorage;
use App\Configs\Config;
use App\Services\ProductFactory;
use App\Services\OrderFactory;
use App\Services\ValidateOrderData;
use App\Services\Mailer;

class OrderController {
    public function get(): string {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST")
            return $this->create();

        $model = ProductFactory::createProduct();
        $data = $model->getBasketData();
        $all_sum = $model->getAllSum($data);
        
        return OrderTemplate::getOrderTemplate($data, $all_sum);
    }

    public function create():string {
        
        $arr = [];
        $arr['fio'] =  strip_tags($_POST['fio']);
        $arr['address'] = strip_tags($_POST['address']);
        $arr['phone'] = strip_tags($_POST['phone']);
        $arr['email'] = strip_tags($_POST['email']);
        $arr['created_at'] = date("d-m-Y H:i:s");	// добавим дату и время создания заказа

        // Валидация (проверка) переданных из формы значений
        if (! ValidateOrderData::validate($arr)) {
            // переадресация обратно на страницу заказа
            header("Location: /pizza221/order");
            return "";
        }

        // Создаем модель Product для работы с данными
        $model = ProductFactory::createProduct();

        // список заказанных продуктов - берем список товаров из корзины
        $products = $model->getBasketData();
        $arr['products'] = $products;
        // подсчитаем общую сумму заказа
        $all_sum = 0;
        foreach ($products as $product) {
            $all_sum += $product['price'] * $product['quantity'];
        }
        $arr['all_sum'] = $all_sum;
    
        $orderModel = OrderFactory::createOrder();
        // сохраняем данные
        $orderModel->saveData($arr);
        
        // отправка емайл
        Mailer::sendOrderMail( $arr['email'] );

        // очистка корзины
        $_SESSION['basket'] = [];

        // сообщение для пользователя
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки";
        
        // переадресация на Главную
	    header("Location: /pizza221/");

        return "";
    }
    
}