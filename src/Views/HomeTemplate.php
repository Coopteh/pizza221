<?php

namespace App\Views;

use App\Views\BaseTemplate;

class HomeTemplate extends BaseTemplate
{
   public static function getTemplate(array $pizza = []): string
   {
       $template = parent::getTemplate();
       // Путь к файлу data.json
       $filePath = __DIR__ . '/../../Storage/data.json';

       // Считываем содержимое файла и декодируем JSON
       if (file_exists($filePath)) {
           $jsonData = file_get_contents($filePath);
           $pizzas = json_decode($jsonData, true);

           // Проверяем, успешно ли декодирован JSON
           if (json_last_error() !== JSON_ERROR_NONE) {
               $pizzas = []; // Если ошибка, используем пустой массив
           }
       } else {
           $pizzas = []; // Если файл не найден, используем пустой массив
       }

       // Генерация HTML-кода для секции "Наши популярные пиццы"
       $pizzaCards = '';
       foreach ($pizzas as $pizza) {
           $pizzaCards .= <<<HTML

<div class="card mb-3" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4 mt-3">
      <img src="{$pizza['image']}" class="img-fluid rounded-start" alt="{$pizza['name']}">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">{$pizza['name']}</h5>
        <p class="card-text">{$pizza['description']}</p>
        <h5 class="card-title"><strong>Цена: </strong>{$pizza['price']} руб.</h5>
        <form class="mt-4" action="/basket" method="POST">
          <input type="hidden" name="id" value="{$pizza['id']}">
          <button type="submit" class="btn btn-custom">Добавить в корзину</button>
        </form>
      </div>
    </div>
  </div>
</div>




HTML;
       }

       $content = <<<HTML
       <style>
       body {
           font-family: 'Arial', sans-serif;
           background-color: #f8f9fa;
       }
       .navbar-brand img {
           transition: transform 0.3s ease;
       }
       .navbar-brand img:hover {
           transform: scale(1.1);
       }
       .hero-section {
           background: url('https://images.pexels.com/photos/708587/pexels-photo-708587.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2') no-repeat center center/cover;
           height: 400px;
           display: flex;
           align-items: center;
           justify-content: center;
           color: white;
           text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
       }
       .card-img-top {
           height: 150px; /* Уменьшенная высота изображения */
           width: 100%; /* Автоматическая ширина */
           object-fit: cover; /* Сохранение пропорций */
       }
       footer {
           background-color: #343a40;
           color: white;
           text-align: center;
           padding: 1rem 0;
           margin-top: 3rem;
       }
       .btn-custom {
           background-color: #ff6347;
           border-color: #ff6347;
       }
       .btn-custom:hover {
           background-color: #e65c40;
           border-color: #e65c40;
       }
       .welcome-container {
           background: url('https://i.pinimg.com/736x/74/42/df/7442df5010f9a71af522f38e787e3aea.jpg') no-repeat center center/cover;
           height: 400px; /* Высота контейнера */
           width: 1200px;
           display: flex;
           align-items: center; /* Вертикальное центрирование */
           justify-content: center; /* Горизонтальное центрирование */
           color: white; /* Цвет текста */
           text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); /* Тень для текста */
           border-radius: 30px; /* Скругление углов */
           overflow: hidden; /* Убедитесь, что содержимое не выходит за границы */
       }   
       .btn-custom {
            background-color: rgb(160, 87, 114); /* Основной цвет кнопки */
            border-color: rgb(208,157,176); /* Цвет границы */
            color: #ffffff; /* Цвет текста */
        }
        .btn-custom:hover {
            background-color: rgb(180,130,150); /* Цвет при наведении */
            border-color: rgb(180,130,150); /* Цвет границы при наведении */
            color: #ffffff; /* Цвет текста */
        }        
   </style>
   <main class="container mt-4">
   <section class="hero-section">
   <div class="welcome-container">
       <div class="text-center">
           <h1 class="display-4 fw-bold">Добро пожаловать в пиццерию!</h1>
           <p class="lead">Лучшие ингредиенты, лучший вкус.</p>
           <a href="http://localhost/products" class="btn btn-custom">Заказать сейчас</a>
       </div>
   </div>
</section>

       <section class="my-5">
           <h2 class="text-center mb-4">Наши популярные пиццы</h2>
           <div class="row row-cols-1 row-cols-md-3 g-4">
               {$pizzaCards}
           </div>
       </section>
   </main>
HTML;

       $resultTemplate = sprintf($template, 'Главная', $content);
       return $resultTemplate;
   }
}
