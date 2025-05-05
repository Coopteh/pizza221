<?php
namespace App\Views;

use App\Views\BaseTemplate;

class OrderTemplate extends BaseTemplate {
    public static function getOrderTemplate(array $arr, float $all_sum): string {
        $template = parent::getTemplate();
        $title = 'Записаться';
        $content = '<h1 class="mb-5">Создание заказа</h1><h3>Корзина</h3>';
        $all_sum = 0;

        // Проверка и отображение флэш-сообщения
        if (isset($_SESSION['flash'])) {
            $content .= '<div class="alert alert-success">' . $_SESSION['flash'] . '</div>';
            unset($_SESSION['flash']); // Удаляем сообщение после отображения
        }

        if (empty($arr)) {
            $content .= <<<HTML
            <div class="row">
                <div class="col-12">
                    - нет добавленных товаров -
                </div>
            </div>
            HTML;
        } else {
            foreach ($arr as $product) {
                $name = htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8');
                $price = htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8');
                $quantity = htmlspecialchars($product['quantity'], ENT_QUOTES, 'UTF-8');
                $sum = htmlspecialchars($product['sum'], ENT_QUOTES, 'UTF-8');
                $all_sum += $sum;

                $content .= <<<HTML
                <div class="row">
                    <div class="col-6">{$name}</div>
                    <div class="col-2">{$quantity} ед. x {$price} руб.</div>
                    <div class="col-2">{$sum} ₽</div>
                </div>
                HTML;
            }
        }
        if ($all_sum > 0) {
            $content .= '<div class="row">
                <div class="col-6">Итого:</div>
                <div class="col-2">' . $all_sum . ' ₽</div>
            </div>';

            if (isset($_SESSION['discount'])) {
                $content .= '<div class="row text-success">
                    <div class="col-6">Примененная скидка:</div>
                    <div class="col-2">' . htmlspecialchars($_SESSION['discount'], ENT_QUOTES, 'UTF-8') . '</div>
                </div>';
            }

        // Итоговая сумма
        if ($all_sum > 0) {
            $content .= <<<HTML
            <div class="row">
                <div class="col-6">Итого:</div>
                <div class="col-2">{$all_sum} ₽</div>
            </div>
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6 float-end">
                    <form action="/avtoservis/basket_clear" method="POST">
                        <button type="submit" class="btn btn-secondary mt-3">Очистить корзину</button>
                    </form>
                </div>
            </div>
            HTML;
        }

        // Добавляем HTML-код формы
        $content .= self::getOrderForm();

        // Добавляем HTML-код колеса удачи
        $content .= <<<HTML
        <div id="wheel-container" style="display: none;">
            <div class="wheel-wrapper">
                <canvas id="wheel" width="400" height="400"></canvas>
                <button id="spin-btn">Крутить колесо!</button>
            </div>
            <div id="result"></div>
        </div>

        <!-- Триггер для открытия колеса (например, кнопка в корзине) -->
        <button id="show-wheel">Получить скидку</button>

        <!-- Контейнер колеса -->
        <div id="wheel-container" style="display: none;">
            <canvas id="wheel" width="400" height="400"></canvas>
            <button id="spin-btn">Крутить!</button>
            <div id="result"></div>
        </div>
        HTML;


        // Возвращаем сгенерированный контент
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}

    private static function getOrderForm(): string {
        $fio = $_SESSION['user_data']['username'] ?? '';
        return '
            <form action="/avtoservis/order" method="POST">
                <div class="mb-3">
                    <label for="fio" class="form-label">Ваше ФИО:</label>
                    <input type="text" name="fio" id="fio" class="form-control" 
                        value="'.htmlspecialchars($fio).'" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Адрес доставки:</label>
                    <input type="text" name="address" id="address" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Телефон:</label>
                    <input type="tel" name="phone" id="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Перейти к выбору времени</button>
            </form>
        ';
    }
    public static function renderHistory(array $orders): string {
        $template = parent::getTemplate();
        $title = 'История заказов';
        
        if (empty($orders)) {
            $content = '<div class="alert alert-info">У вас пока нет заказов</div>';
        } else {
            $content = '<div class="order-history"><table class="table">';
            $content .= '<thead><tr>
                <th>ID</th>
                <th>Дата</th>
                <th>Товары</th>
                <th>Сумма</th>
                <th>Статус</th>
            </tr></thead><tbody>';
            
            foreach ($orders as $order) {
                $content .= sprintf(
                    '<tr>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s руб.</td>
                        <td>%s</td>
                    </tr>',
                    htmlspecialchars($order['id']),
                    htmlspecialchars($order['created']),
                    htmlspecialchars($order['products'] ?? 'Нет данных'),
                    htmlspecialchars($order['total'] ?? '0'),
                    htmlspecialchars(\App\Models\Order::getStatusText($order['status'] ?? 0))
                );
            }
            
            $content .= '</tbody></table></div>';
        }
        
        return sprintf($template, $title, $content);
    }
}