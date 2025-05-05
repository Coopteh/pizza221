<?php 
namespace App\Controllers;

use App\Models\Product;
use App\Views\ProductTemplate;
use App\Services\FileStorage;
use App\Services\ProductDBStorage;
use App\Configs\Config;

class ProductController {
    public function get(?int $id): string {

        if (Config::STORAGE_TYPE == Config::TYPE_FILE) {
            $serviceStorage = new FileStorage();
            $model = new Product($serviceStorage, Config::FILE_PRODUCTS);
        }
        if (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $serviceStorage = new ProductDBStorage();
            $model = new Product($serviceStorage, Config::TABLE_PRODUCTS);
        }

        $data = $model->loadData();

        if (!isset($id))
            return ProductTemplate::getAllTemplate($data);
        if (($id) && ($id <= count($data))) {
            $record= $data[$id-1];
            return ProductTemplate::getCardTemplate($record);
        } else
            return ProductTemplate::getCardTemplate(null);
    }
    public function addToBasket(): void {
        if (!isset($_POST['product_id'], $_POST['quantity'])) {
            $_SESSION['flash'] = "Не указан товар или количество";
            header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit;
        }
    
        $productId = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
    
        // Получаем полные данные товара
        $pdo = new PDO('mysql:host=localhost;dbname=is221', 'root', '');
        $stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$product) {
            $_SESSION['flash'] = "Товар не найден";
            header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit;
        }
    
        // Инициализация корзины
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }
    
        // Добавляем товар с ВСЕМИ необходимыми данными
        $_SESSION['basket'][$productId] = [
            'id' => (int)$product['id'],
            'price' => (float)$product['price'],
            'quantity' => (int)$_POST['quantity'],
            'name' => $product['name']
        ];
    
        $_SESSION['flash'] = "Товар добавлен в корзину";
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }
}
