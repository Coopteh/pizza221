<?php 
namespace App\Controllers;

use App\Views\OrderTemplate;
use App\Models\Product;

class OrderController {
    public function get(): string {
        // Метод GET, POST, DELETE
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            return $this->create();
        }

        $model = new Product();
        $data = $model->getBasketData();

        return OrderTemplate::getOrderTemplate($data);
    }

    public function create(): string {
        try {
            $arr = [];
            $arr['fio'] = urldecode($_POST['fio'] ?? '');
            $arr['address'] = urldecode($_POST['address'] ?? '');
            $arr['phone'] = $_POST['phone'] ?? '';
            $arr['created_at'] = date("d-m-Y H:i:s");

            if (empty($arr['fio']) || empty($arr['address']) || empty($arr['phone'])) {
                throw new \InvalidArgumentException('Все поля должны быть заполнены');
            }

            $model = new Product();
            $products = $model->getBasketData();
            if (empty($products)) {
                throw new \Exception('В корзине нет товаров');
            }
            $arr['products'] = $products;

            $all_sum = 0;
            foreach ($products as $product) {
                if (!isset($product['price'], $product['quantity'])) {
                    throw new \Exception('В корзине товары с пустыми данными');
                }
                $all_sum += $product['price'] * $product['quantity'];
            }
            $arr['all_sum'] = $all_sum;

            $model->saveData($arr);

            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['basket'] = [];
            $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки";

            header("Location: /pizza221/");
            return '';
        } catch (\Exception $e) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $_SESSION['flash'] = $e->getMessage();
            header("Location: /pizza221/order");
            return ''; 
        }
    }
}
