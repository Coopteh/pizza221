<?php
namespace App\Views;
use App\Views\BaseTemplate;

class OrderTemplate extends BaseTemplate
{
    public static function getOrderTemplate(array $arr, array $userData = []): string
{
    $template = parent::getTemplate();
    $title = 'Создание заказа';
    $username = htmlspecialchars($userData['username'] ?? '');
    $email = htmlspecialchars($userData['email'] ?? '');
    $address = htmlspecialchars($userData['address'] ?? '');
    $phone = htmlspecialchars($userData['phone'] ?? '');
    $avatar = htmlspecialchars($userData['avatar'] ?? '/assets/images/default-avatar.png'); 

    // Извлечение данных профиля (адрес и телефон)
    $profileAddress = htmlspecialchars($userData['address'] ?? '');
    $profilePhone = htmlspecialchars($userData['phone'] ?? '');

    // Заголовок
    $content = <<<HTML
    <h1 class="text-center mb-5">Создание заказа</h1>
HTML;

    // Макет с двумя колонками: список заказа слева, выбор оплаты справа
    $content .= <<<HTML
    <div class="row">
        <div class="col-md-8">
            <h3 class="mb-4">Корзина</h3>
HTML;

    $all_sum = 0;

    if (!empty($arr)) {
        foreach ($arr as $product) {
            $name = $product['name'];
            $price = $product['price'];
            $quantity = $product['quantity'];

            // Формирование пути к изображению на основе id
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . "/assets/image/{$product['id']}.png";
            $image = file_exists($imagePath)
                ? "/assets/image/{$product['id']}.png"
                : '/assets/image/default.png'; // Запасное изображение

            $sum = $price * $quantity;
            $all_sum += $sum;

            $content .= <<<LINE
            <div class="card mb-3" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="row g-0 align-items-center">
                    <div class="col-md-3 text-center">
                        <img src="{$image}" class="img-fluid rounded-start" alt="{$name}" style="height: 150px; object-fit: cover;">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h5 class="card-title mb-1">{$name}</h5>
                            <p class="card-text mb-1">Цена за единицу: {$price} ₽</p>
                            <p class="card-text mb-1">Количество: {$quantity} ед.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="card-text mb-0"><strong>Итого:</strong> {$sum} ₽</p>
                                <form action="/basket_remove" method="POST" class="ms-auto">
                                    <input type="hidden" name="id" value="{$product['id']}">
                                    <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
LINE;
        }

        // Итоговая сумма
        $content .= <<<HTML
        <div class="card mb-3" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="card-body text-end">
                <h5 class="card-title mb-0">Общая сумма: <strong>{$all_sum} ₽</strong></h5>
            </div>
        </div>
HTML;
    } else {
        // Если корзина пуста
        $content .= <<<HTML
        <div class="alert alert-info text-center" role="alert">
            Ваша корзина пуста.
        </div>
HTML;
    }

    // Закрываем колонку с корзиной
    $content .= <<<HTML
        </div>

        <!-- Колонка с выбором оплаты -->
        <div class="col-md-4">
            <div class="sticky-top" style="top: 20px;">
                <h4 class="text-center mb-4">Способ оплаты</h4>
                <div class="d-flex flex-column gap-3">
                    <button type="button" class="btn btn-outline-primary payment-option w-100" data-payment="sbp">
                        <i class="fas fa-qrcode"></i> По СБП
                    </button>
                    <button type="button" class="btn btn-outline-primary payment-option w-100" data-payment="card">
                        <i class="fas fa-credit-card"></i> По номеру карты
                    </button>
                    <button type="button" class="btn btn-outline-primary payment-option w-100" data-payment="yandex_pay">
                        <i class="fab fa-yandex"></i> Yandex Pay
                    </button>
                    <button type="button" class="btn btn-outline-primary payment-option w-100" data-payment="cash">
                        <i class="fas fa-money-bill-wave"></i> При получении
                    </button>
                </div>
            </div>
        </div>
    </div>
HTML;

    // Форма оформления заказа
    $content .= <<<HTML
    <div class="card mt-4" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-body">
            <h4 class="text-center mb-4">Оформление заказа</h4>
            <form action="/order" method="POST" id="order-form">
                <div class="mb-3">
                    <label for="fio" class="form-label">Ваше ФИО:</label>
                    <input type="text" class="form-control" value="{$username}" id="fio" name="fio" placeholder="Введите ваше ФИО" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control"  value="{$email}" id="email" name="email" placeholder="Введите ваш email" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Адрес доставки:</label>
                    <input type="text" class="form-control"  value="{$address}"  id="address" name="address" placeholder="Введите адрес доставки" 
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Телефон:</label>
                    <input type="tel" class="form-control"  value="{$phone}"  id="phone" name="phone" placeholder="Введите номер телефона" 
                </div>
                
                <input type="hidden" id="selected-payment" name="payment_method" value="">
                <button type="submit" class="btn btn-custom w-100" id="create-order-button">Создать заказ</button>
            </form>
        </div>
    </div>
HTML;

    // Кнопка очистки корзины
    $content .= <<<HTML
    <div class="text-center mt-3">
        <form action="/basket_clear" method="POST">
            <button type="submit" class="btn btn-secondary">Очистить корзину</button>
        </form>
    </div>

    <!-- JavaScript для выбора способа оплаты и отключения кнопки -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Находим все кнопки с классом payment-option
        const paymentButtons = document.querySelectorAll('.payment-option');
        const selectedPaymentInput = document.getElementById('selected-payment');
        const orderForm = document.getElementById('order-form');
        const createOrderButton = document.getElementById('create-order-button');

        // Проверяем, есть ли товары в корзине
        const cartItems = document.querySelectorAll('.card.mb-3'); // Элементы товаров в корзине
        if (cartItems.length === 0) {
            createOrderButton.disabled = true;
            createOrderButton.classList.add('disabled');
        }

        // Добавляем обработчик клика для каждой кнопки оплаты
        paymentButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Убираем активный класс у всех кнопок
                paymentButtons.forEach(btn => btn.classList.remove('active'));

                // Добавляем активный класс к выбранной кнопке
                this.classList.add('active');

                // Устанавливаем значение выбранного способа оплаты
                const paymentMethod = this.getAttribute('data-payment');
                selectedPaymentInput.value = paymentMethod;
            });
        });

        // Проверяем, что способ оплаты выбран перед отправкой формы
        orderForm.addEventListener('submit', function (event) {
            if (!selectedPaymentInput.value) {
                event.preventDefault();
                alert('Пожалуйста, выберите способ оплаты.');
            }
        });
    });
    </script>
HTML;

    $resultTemplate = sprintf($template, $title, $content);
    return $resultTemplate;
}
}