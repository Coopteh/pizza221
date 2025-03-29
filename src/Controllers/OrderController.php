<?php
namespace App\Controllers;
use App\Models\Product;
use App\Views\OrderTemplate;
class OrderController{
    public function get(): string{
        // метод GET, POST, DELETE
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST")
            return $this->create();
        $productModel = new Product();
        $data = $productModel -> getBasketData();
        $orderTemplate = new OrderTemplate();
        $result = $orderTemplate -> getOrderTemplate($data);
        return $result;
    }
    public function create() {
        session_start();
        $arr = [];
        $arr['fio'] = urldecode( $_POST['fio'] );
            $arr['address'] = urldecode( $_POST['address'] );
            $arr['phone'] = $_POST['phone'];
            $arr['email'] = $_POST['email'];
            $arr['created_at'] = date("d-m-Y H:i:s");	// добавим дату и время создания заказа

            if (! $this->validate($arr)) {
                // переадресация обратно на страницу заказа
                header("Location: /pizza221/order");
                return "";
            }
        $model = new Product();
        // список заказанных продуктов - берем список товаров из корзины
            $products = $model->getBasketData();
            $arr['products'] = $products;
        // подсчитаем общую сумму заказа
            $all_sum = 0;
            foreach ($products as $product) {
            $all_sum += $product['price'] * $product['quantity'];
            }
            $arr['all_sum'] = $all_sum;

            $model->saveData($arr);

            $_SESSION['basket'] = [];
        
            $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки";
        
            header("Location: /pizza221/");
            return '';
    }
    function validate(array $data): bool {
        // Проверка ФИО
        if (!isset($data['fio'])) {
            $_SESSION['flash'] = "Не заполнено поле ФИО";
            return false;
        }
    
        // Проверка адреса
        if (!isset($data['address']) || 
            strlen(trim($data['address'])) < 10 || 
            strlen(trim($data['address'])) > 200) {
                $_SESSION['flash'] = "Поле адреса должно быть олее 10 символов, но не более 200";
            return false;
        }
    
        // Проверка телефона
        if (!isset($data['phone'])) {
            $_SESSION['flash'] = "Не правльно заполнен номер телефона";
            return false;
        }
        $cleanedPhone = preg_replace('/[^\\d]/', '', $data['phone']);
        if (strlen($cleanedPhone) !== 11 || 
            !in_array($cleanedPhone[0], ['7', '8'])) {
                $_SESSION['flash'] = "Не верный номер телефона";
            return false;
        }
    
        // Проверка email
        if (!isset($data['email']) || 
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash'] = "Не правильно заполнено поле имейл"; 
            return false;
        }
    
        return true;
    }
}