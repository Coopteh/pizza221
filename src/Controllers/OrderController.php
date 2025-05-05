<?php 
namespace App\Controllers;

use App\Views\OrderTemplate;
use App\Services\ProductFactory;
use App\Services\ValidateOrderData;
use App\Services\UserDBStorage;
use Exception;
use PDO;

class OrderController {
    private UserDBStorage $storage;

    public function __construct() {
        $this->storage = new UserDBStorage();
    }

    public function get(): string {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            return $this->create();
        }

        $model = ProductFactory::createProduct();
        $data = $model->getBasketData();
        $all_sum = $model->getAllSum($data);
        
        return OrderTemplate::getOrderTemplate($data, $all_sum);
    }

    public function create(): string {
        $arr = [];
        $arr['fio'] = strip_tags($_POST['fio']??'');
        $arr['address'] = strip_tags($_POST['address']??'');
        $arr['phone'] = strip_tags($_POST['phone']??'');
        $arr['email'] = strip_tags($_POST['email']??'');
        $arr['created_at'] = date("d-m-Y H:i:s");

        if (!ValidateOrderData::validate($arr)) {
            header("Location: /avtoservis/order");
            exit;
        }

        $_SESSION['order_data'] = $arr;
        $_SESSION['user_data'] = $arr;
        $_SESSION['flash'] = "Запись успешно создана!";
        header("Location: /avtoservis/select_time");
        exit;
    }

    public function selectTime(): string {
        if (!isset($_SESSION['order_data'])) {
            header("Location: /avtoservis/order");
            exit;
        }
    
        return '
            <form action="/avtoservis/confirm_booking" method="POST">
                <input type="datetime-local" name="bookingDate" required>
                <input type="hidden" name="fio" value="'.htmlspecialchars($_SESSION['order_data']['fio']).'">
                <input type="hidden" name="address" value="'.htmlspecialchars($_SESSION['order_data']['address']).'">
                <input type="hidden" name="phone" value="'.htmlspecialchars($_SESSION['order_data']['phone']).'">
                <input type="hidden" name="email" value="'.htmlspecialchars($_SESSION['order_data']['email']).'">
                <button type="submit">Подтвердить запись</button>
            </form>
        ';
    }
    
    public function confirmBooking(): void {
        try {
            if (!isset($_SESSION['user_id'])) {
                throw new Exception("Требуется авторизация");
            }
    
            if (empty($_SESSION['basket'])) {
                throw new Exception("Корзина пуста");
            }
    
            // Восстановление данных товаров
            $db = new PDO('mysql:host=localhost;dbname=is221', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $original_sum = 0;
            foreach ($_SESSION['basket'] as $productId => &$item) {
                if (!isset($item['price']) || !isset($item['id'])) {
                    $stmt = $db->prepare("SELECT id, price FROM products WHERE id = ?");
                    $stmt->execute([$productId]);
                    $product = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($product) {
                        $item['id'] = (int)$product['id'];
                        $item['price'] = (float)$product['price'];
                    }
                }
                
                if (!isset($item['quantity'])) {
                    $item['quantity'] = 1;
                }
                
                $original_sum += $item['price'] * $item['quantity'];
            }
            unset($item);
    
            // Применяем скидку
            $discounted_sum = $original_sum;
            if (isset($_SESSION['discount'])) {
                $discountText = $_SESSION['discount'];
                if (strpos($discountText, '%') !== false) {
                    $percent = (float)str_replace('% скидки', '', $discountText);
                    $discounted_sum *= (1 - $percent/100);
                } elseif ($discountText === "Бесплатная доставка") {
                    // Если у вас есть стоимость доставки, вычтите её здесь
                    // $discounted_sum -= DELIVERY_COST;
                }
            }
    
            $orderData = [
                'user_id' => $_SESSION['user_id'],
                'fio' => $_POST['fio'] ?? '',
                'address' => $_POST['address'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'original_sum' => $original_sum,
                'discounted_sum' => $discounted_sum,
                'discount' => $_SESSION['discount'] ?? null,
                'products' => []
            ];
    
            foreach ($_SESSION['basket'] as $item) {
                $orderData['products'][] = [
                    'id' => (int)$item['id'],
                    'price' => (float)$item['price'],
                    'quantity' => (int)$item['quantity']
                ];
            }
    
            if (empty($orderData['products'])) {
                throw new Exception("Невозможно оформить заказ. Корзина пуста или содержит ошибки.");
            }
    
            $orderId = $this->storage->saveOrder($orderData);
            
            $_SESSION['flash'] = "Заказ #$orderId успешно оформлен!";
            unset($_SESSION['basket']);
            unset($_SESSION['discount']); // Очищаем скидку после использования
            header("Location: /avtoservis/history");
            exit;
        } catch (Exception $e) {
            $_SESSION['flash'] = $e->getMessage();
            error_log("Order confirmation failed: " . $e->getMessage());
            header("Location: /avtoservis/order");
            exit;
        }
    }


    public function history(): string {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /avtoservis/login");
            exit;
        }
        
        try {
            $orders = $this->storage->getOrderHistory($_SESSION['user_id']);
            return OrderTemplate::renderHistory($orders);
        } catch (Exception $e) {
            error_log("Error fetching order history: " . $e->getMessage());
            $_SESSION['flash'] = "Ошибка при загрузке истории заказов";
            header("Location: /avtoservis/");
            exit;
        }
    }
    public function applyDiscount() {
        if (isset($_POST['discount'])) {
            $_SESSION['discount'] = $_POST['discount'];
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}