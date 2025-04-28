<?php 
namespace App\Controllers;

use App\Views\OrderTemplate;
use App\Services\UserDBStorage;
use App\Configs\Config;
use App\Services\ProductFactory;
use App\Services\OrderFactory;
use App\Services\ValidateOrderData;
use App\Services\Mailer;

class OrderController {
    public function get(): string {
        global $user_id;

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST")
            return $this->create();

        // данные из корзины
        $model = ProductFactory::createProduct();
        $data = $model->getBasketData();
        $all_sum = $model->getAllSum($data);
        
        // данные из профиля
        $dataProfile = null;
        if ($user_id) {
            if (Config::STORAGE_TYPE == Config::TYPE_DB) {
                $serviceDB = new UserDBStorage();
                $dataProfile = $serviceDB->getUserData($user_id);
                if (! $dataProfile) {
                    $_SESSION['flash'] = "Ошибка получения данных пользователя";
                }
            }
        }

        return OrderTemplate::getOrderTemplate($data, $all_sum, $dataProfile);
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
