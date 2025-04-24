<?php

namespace App\Views;

use App\Views\BaseTemplate;

class ProductTemplate extends BaseTemplate {
    public static function getCardTemplate(?array $data) {
        $template = parent::getTemplate();
        if ($data) {
            $title = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');

            $content = <<<HTML
            <main class="row p-5">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4 mt-3">
                            <img src="{$data['image']}" class="img-fluid rounded-start" alt="Изображение товара">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{$title}</h5>
                                <p class="card-text">{$data['description']}</p>
                                <p class="card-text"><strong class="text-body-primary">{$data['price']} руб.</strong></p>
                                <form class="mt-4" action="/avtoservis/basket" method="POST">
                                    <input type="hidden" name="id" value="{$data['id']}">
                                    <button type="submit" class="btn btn-primary">Добавить в корзину</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            HTML;
        } else {
            $title = "404 ошибка";
            $content = <<<HTML
            <main class="row p-5">
                <p>404 ошибка <br> Страница не найдена</p>
            </main>
            HTML;
        }
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }

    public static function getAllTemplate(array $arr): string {
        $template = parent::getTemplate();
        $str = '<div class="container"><div class="row">';

        // Для каждого товара
        foreach ($arr as $key => $item) {
            $itemName = htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
            $itemDescription = htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8');
            $itemPrice = htmlspecialchars($item['price'], ENT_QUOTES, 'UTF-8');

            $element_template = <<<HTML
            <div class="col-6 col-md-4 mb-4">
                <div class="card">
                    <img src="{$item['image']}" class="card-img-top" alt="{$itemName}">
                    <div class="card-body">
                        <h5 class="card-title"><a href="/avtoservis/products/{$item['id']}">{$itemName}</a></h5>
                        <p class="card-text">{$itemDescription}</p>
                        <h6 class="card-price">{$itemPrice} ₽</h6>
                        <form class="mt-4" action="/avtoservis/basket" method="POST">
                            <input type="hidden" name="id" value="{$item['id']}">
                            <button type="submit" class="btn btn-primary">Добавить в корзину</button>
                        </form>
                    </div>
                </div>
            </div>
            HTML;

            $str .= $element_template; // Добавляем элемент в строку
        }

        $str .= '</div></div>'; // Закрываем div контейнеров
        $resultTemplate = sprintf($template, 'Каталог продукции', $str);
        return $resultTemplate;
    }
}