<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Services\ProductFactory;
use App\Services\OrderFactory;
use App\Services\ValidateOrderData;
use App\Views\OrderTemplate;
use App\Services\Mailer;
use App\Services\UserDBStorage;

class OrderController
{
    public function get(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            return $this->create();
        }

        $model = ProductFactory::createProduct();
        $data = $model->getBasketData();

        $orderTemplate = new OrderTemplate();
        return $orderTemplate->getOrderTemplate($data);
    }

    public function create(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!ValidateOrderData::validate($_POST)) {
            header("Location: /order");
            return "";
        }

        $orderData = $this->prepareOrderData($_POST);
        $orderModel = OrderFactory::createOrder();
        $orderId = $orderModel->saveData($orderData);

        $this->sendOrderConfirmation($orderData, $orderId);

        $_SESSION['basket'] = [];
        $_SESSION['flash'] = "Спасибо! Ваш заказ успешно создан и передан службе доставки.";
        header("Location: /pizza221/");
        return "";
    }

    private function prepareOrderData(array $postData): array
    {
        $model = ProductFactory::createProduct();
        $products = $model->getBasketData();

        $totalSum = array_reduce($products, function($sum, $product) {
            return $sum + ($product['price'] * $product['quantity']);
        }, 0);

        return [
            'fio' => htmlspecialchars(urldecode($postData['fio'])),
            'address' => htmlspecialchars(urldecode($postData['address'])),
            'phone' => htmlspecialchars($postData['phone']),
            'email' => filter_var($postData['email'], FILTER_SANITIZE_EMAIL),
            'payment_method' => htmlspecialchars($postData['payment_method']),
            'created_at' => date("d-m-Y H:i:s"),
            'products' => $products,
            'all_sum' => $totalSum
        ];
    }

    private function sendOrderConfirmation(array $orderData, $orderId): bool
    {
        if (empty($orderData['email'])) {
            error_log("Email не указан");
            return false;
        }

        $mail = new PHPMailer(true);

        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.mail.ru';
            $mail->SMTPAuth = true;
            $mail->Username = 'v.milevskiy@coopteh.ru';
            $mail->Password = 'qRbdMaYL6mfuiqcGX38z';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            // Email content
            $mail->setFrom('v.milevskiy@coopteh.ru', 'PIZZA-221');
            $mail->addAddress($orderData['email']);
            $mail->addReplyTo('no-reply@coopteh.ru', 'No Reply');
            $mail->isHTML(true);
            $mail->Subject = 'Ваш заказ #' . $orderId . ' в PIZZA-221';
            $mail->Body = $this->buildEmailBody($orderData, $orderId);
            $mail->AltBody = $this->buildTextEmailBody($orderData, $orderId);

            return $mail->send();
        } catch (Exception $e) {
            error_log("Mailer Error: " . $e->getMessage());
            return false;
        }
    }

    private function buildEmailBody(array $orderData, $orderId): string
    {
        $productsHtml = '';
        foreach ($orderData['products'] as $product) {
            $totalPrice = number_format($product['price'] * $product['quantity'], 2);
            $productsHtml .= "<tr>
                <td>{$product['name']}</td>
                <td>{$product['quantity']}</td>
                <td>{$product['price']} руб.</td>
                <td>{$totalPrice} руб.</td>
            </tr>";
        }

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .order-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .order-table th, .order-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .order-table th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; }
        .header { color: #d9534f; }
    </style>
</head>
<body>
    <h2 class="header">Спасибо за ваш заказ в PIZZA-221!</h2>
    <p><strong>Номер заказа:</strong> #{$orderId}</p>
    <p><strong>Дата заказа:</strong> {$orderData['created_at']}</p>
    
    <h3>Состав заказа:</h3>
    <table class="order-table">
        <thead>
            <tr>
                <th>Товар</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Сумма</th>
            </tr>
        </thead>
        <tbody>
            {$productsHtml}
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3">Итого:</td>
                <td>{$orderData['all_sum']} руб.</td>
            </tr>
        </tfoot>
    </table>
    
    <h3>Информация о доставке:</h3>
    <p><strong>ФИО:</strong> {$orderData['fio']}</p>
    <p><strong>Адрес:</strong> {$orderData['address']}</p>
    <p><strong>Телефон:</strong> {$orderData['phone']}</p>
    <p><strong>Способ оплаты:</strong> {$orderData['payment_method']}</p>
    
    <p>Если у вас есть вопросы, свяжитесь с нами по телефону.</p>
    <p>С уважением,<br>Команда PIZZA-221</p>
</body>
</html>
HTML;
    }

    private function buildTextEmailBody(array $orderData, $orderId): string
    {
        $productsText = '';
        foreach ($orderData['products'] as $product) {
            $totalPrice = $product['price'] * $product['quantity'];
            $productsText .= "{$product['name']} - {$product['quantity']} x {$product['price']} руб. = {$totalPrice} руб.\n";
        }

        return <<<TEXT
Спасибо за ваш заказ в PIZZA-221!

Номер заказа: #{$orderId}
Дата заказа: {$orderData['created_at']}

Состав заказа:
{$productsText}

Итого: {$orderData['all_sum']} руб.

Информация о доставке:
ФИО: {$orderData['fio']}
Адрес: {$orderData['address']}
Телефон: {$orderData['phone']}
Способ оплаты: {$orderData['payment_method']}

Если у вас есть вопросы, свяжитесь с нами.

С уважением,
Команда PIZZA-221
TEXT;
    }
}