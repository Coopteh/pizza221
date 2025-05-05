<?php
namespace App\Services;

use PDO;
use PDOException;
use InvalidArgumentException;
use Exception;

class UserDBStorage {
    private PDO $pdo;

    public function __construct() {
        // В конструкторе UserDBStorage
        $this->pdo = new PDO('mysql:host=localhost;dbname=is221', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function saveAppointment(array $data): bool {
        $stmt = $this->pdo->prepare("INSERT INTO appointments 
            (user_id, date, time, service_type, comments, status) 
            VALUES (:user_id, :date, :time, :service_type, :comments, 'pending')");
        
        return $stmt->execute([
            ':user_id' => $data['user_id'],
            ':date' => $data['date'],
            ':time' => $data['time'],
            ':service_type' => $data['service_type'] ?? null,
            ':comments' => $data['comments'] ?? null
        ]);
    }

    public function getUserHistory(int $userId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM appointments 
                                   WHERE user_id = :user_id 
                                   ORDER BY date DESC, time DESC");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancelAppointment(int $userId, int $appointmentId): bool {
        $stmt = $this->pdo->prepare("UPDATE appointments 
                                   SET status = 'cancelled' 
                                   WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([
            ':id' => $appointmentId,
            ':user_id' => $userId
        ]);
    }

    public function isSlotAvailable(string $date, string $time): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM appointments 
                                   WHERE date = :date AND time = :time 
                                   AND status != 'cancelled'");
        $stmt->execute([':date' => $date, ':time' => $time]);
        return $stmt->fetchColumn() == 0;
    }

    public function getAvailableSlots(): array {
        // Здесь должна быть логика получения доступных временных слотов
        // Например, можно вернуть фиксированный набор времен
        return [
            '09:00', '10:00', '11:00', '12:00',
            '13:00', '14:00', '15:00', '16:00'
        ];
    }
    public function saveOrder(array $orderData): int {
        if (!isset($orderData['user_id']) || !is_int($orderData['user_id'])) {
            throw new InvalidArgumentException("Некорректный ID пользователя");
        }
    
        $this->pdo->beginTransaction();
        
        try {
            $total = array_reduce($orderData['products'], function($sum, $item) {
                return $sum + ($item['price'] * $item['quantity']);
            }, 0);
    
            $stmt = $this->pdo->prepare("INSERT INTO orders 
                (user_id, fio, address, phone, email, all_sum, created, status) 
                VALUES (:user_id, :fio, :address, :phone, :email, :total, NOW(), 1)");
            
            $stmt->execute([
                ':user_id' => $orderData['user_id'],
                ':fio' => $orderData['fio'],
                ':address' => $orderData['address'],
                ':phone' => $orderData['phone'],
                ':email' => $orderData['email'],
                ':total' => $total
            ]);
            
            $orderId = $this->pdo->lastInsertId();
            
            $stmt = $this->pdo->prepare("INSERT INTO order_item 
                (order_id, product_id, count_item, price_item, sum_item) 
                VALUES (:order_id, :product_id, :quantity, :price, :sum)");
                
            foreach ($orderData['products'] as $product) {
                if (!isset($product['id'], $product['price'], $product['quantity'])) {
                    throw new InvalidArgumentException("Неполные данные товара");
                }
                
                $sum = $product['price'] * $product['quantity'];
                
                $stmt->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $product['id'],
                    ':quantity' => $product['quantity'],
                    ':price' => $product['price'],
                    ':sum' => $sum
                ]);
            }
            
            $this->pdo->commit();
            return $orderId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Ошибка сохранения заказа: " . $e->getMessage());
        }
    }
    public function getUserData(int $userId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            throw new \RuntimeException("User with ID {$userId} not found");
        }
        
        return $user;
    }
    public function updateProfile(int $userId, array $data): bool {
        try {
            // Подготовка запроса
            $sql = "UPDATE users SET 
                    username = :username,
                    email = :email,
                    address = :address,
                    phone = :phone,
                    avatar = :avatar
                    WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            
            // Параметры
            $params = [
                ':username' => $data['username'],
                ':email' => $data['email'],
                ':address' => $data['address'] ?? null,
                ':phone' => $data['phone'] ?? null,
                ':avatar' => $data['avatar'] ?? null,
                ':id' => $userId
            ];
            
            error_log("Executing query: " . $sql);
            error_log("With params: " . print_r($params, true));
            
            $result = $stmt->execute($params);
            
            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                error_log("Database error: " . print_r($errorInfo, true));
                return false;
            }
            
            return true;
            
        } catch (PDOException $e) {
            error_log("PDO Exception: " . $e->getMessage());
            return false;
        }
    }
    public function getOrderHistory(int $userId): array {
        $stmt = $this->pdo->prepare("
            SELECT o.*, 
                   GROUP_CONCAT(p.name SEPARATOR ', ') AS products,
                   SUM(oi.price_item * oi.count_item) AS total,
                   CASE 
                       WHEN o.status = 1 THEN 'Обработан'
                       WHEN o.status = 0 THEN 'В обработке'
                       ELSE 'Отменен'
                   END AS status_text
            FROM orders o
            LEFT JOIN order_item oi ON o.id = oi.order_id
            LEFT JOIN products p ON oi.product_id = p.id
            WHERE o.user_id = :user_id
            GROUP BY o.id
            ORDER BY o.created DESC
        ");
        
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function loginUser(string $username, string $password): bool {
        $stmt = $this->pdo->prepare("SELECT id, password FROM users WHERE username = :username OR email = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$user) {
            return false;
        }
    
        return password_verify($password, $user['password']);
    }
    public function getUserByUsername(string $username): array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }
    public function userExists(string $username): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetchColumn() > 0;
    }
}