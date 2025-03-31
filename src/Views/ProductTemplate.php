<?php
namespace App\Views;
use App\Views\BaseTemplate;

class ProductTemplate extends BaseTemplate
{
    public static function getAllTemplate(array $arr): string
    {
        $template = parent::getTemplate();
        $title = 'Каталог продукции';

        // Разделение продуктов по категориям
        $categories = [
            'pizza' => [],
            'snack' => [],
            'drink' => [],
            'sauce' => [],
        ];

        // Массив соответствия ключей категорий и их русскоязычных названий
        $categoryNames = [
            'pizza' => 'Пицца',
            'snack' => 'Закуски',
            'drink' => 'Напитки',
            'sauce' => 'Соусы',
        ];

        foreach ($arr as $item) {
            if (isset($categories[$item['category']])) {
                $categories[$item['category']][] = $item;
            }
        }

        // Генерация меню категорий с использованием русскоязычных названий
        $menuItems = '';
        foreach ($categoryNames as $key => $name) {
            $menuItems .= <<<HTML
            <li class="nav-item">
                <a class="nav-link" href="#$key">$name</a>
            </li>
HTML;
        }

        $menu = <<<HTML
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4" style="position: sticky; top: 0; z-index: 1000;">
            <div class="container-fluid">
                <ul class="navbar-nav justify-content-center w-100">
                    $menuItems
                </ul>
            </div>
        </nav>
HTML;

        // Содержимое страницы
        $content = '';

        // Заголовок страницы с фоновым изображением
        $content .= <<<HTML
        <div class="text-center py-5" style="
            background-image: url('https://i.pinimg.com/736x/74/42/df/7442df5010f9a71af522f38e787e3aea.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            border-radius: 20px; /* Скругление углов */
            overflow: hidden; /* Обрезка фона по границам */
        ">
            <h1 class="display-4 fw-bold">Каталог продукции</h1>
        </div>
HTML;

        // Добавление меню
        $content .= $menu;

        // Генерация разделов для каждой категории
        foreach ($categories as $category => $items) {
            $categoryName = $categoryNames[$category] ?? ucfirst($category); // Русское название или дефолтное

            $content .= <<<HTML
            <section id="$category" class="mb-5">
                <h2 class="text-center mb-4">$categoryName</h2>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
HTML;

            foreach ($items as $item) {
                $content .= <<<HTML
                    <div class="col">
                        <div class="card h-100" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                            <img src="{$item['image']}" class="card-img-top" alt="{$item['name']}" style="height: 200px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <a href="http://localhost/products/{$item['id']}" style="text-decoration: none; color: inherit;">
                                        <h5 class="card-title">{$item['name']}</h5>
                                    </a>
                                    <p class="card-text">{$item['description']}</p>
                                </div>
                                <div>
                                    <h5 class="card-title"><strong>Цена: </strong>{$item['price']} руб.</h5>
                                    <form class="mt-3" action="/basket" method="POST">
                                        <input type="hidden" name="id" value="{$item['id']}">
                                        <button type="submit" class="btn btn-custom w-100">Добавить в корзину</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
HTML;
            }

            $content .= <<<HTML
                </div>
            </section>
HTML;
        }

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }

    /**
     * Генерирует HTML-код для отображения карточки одного товара.
     *
     * @param array $data Данные о товаре (id, name, price, image, description и т.д.)
     * @return string HTML-код карточки товара
     */
    public static function getCardTemplate(array $data = null): string
{
    $template = parent::getTemplate();
    $title = 'Карточка товара';

    // Если данные отсутствуют, показываем сообщение об ошибке
    if ($data === null) {
        $content = '<div class="alert alert-danger" role="alert">Товар не найден.</div>';
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }

    // Генерация HTML-кода для карточки товара
    $content = <<<HTML
    <div class="card mb-3" style="max-width: 540px; margin: 0 auto;">
        <div class="row g-0">
            <div class="col-md-4 mt-3">
                <img src="{$data['image']}" class="img-fluid rounded-start" alt="{$data['name']}" style="height: 150px; object-fit: cover;">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{$data['name']}</h5>
                    <p class="card-text">{$data['description']}</p>
                    <h5 class="card-title"><strong>Цена:</strong> {$data['price']} руб.</h5>
                    <form class="mt-4" action="/basket" method="POST">
                        <input type="hidden" name="id" value="{$data['id']}">
                        <button type="submit" class="btn btn-custom">Добавить в корзину</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
HTML;

    $resultTemplate = sprintf($template, $title, $content);
    return $resultTemplate;
}
}