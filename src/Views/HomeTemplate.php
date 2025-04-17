<?php

namespace App\Views;

use App\Views\BaseTemplate;

class HomeTemplate extends BaseTemplate
{
    public static function getTemplate(): string
    {
        $template = parent::getTemplate();

        // Генерация HTML-кода для секции "Преимущества пиццерии"
        $advantages = [
            [
                'icon' => 'fa-solid fa-pizza-slice',
                'title' => 'Лучшие ингредиенты',
                'description' => 'Мы используем только свежие и качественные продукты.'
            ],
            [
                'icon' => 'fa-solid fa-truck-fast',
                'title' => 'Быстрая доставка',
                'description' => 'Доставляем горячую пиццу за 30 минут.'
            ],
            [
                'icon' => 'fa-solid fa-hand-holding-heart',
                'title' => 'Отличное обслуживание',
                'description' => 'Наша команда всегда рада помочь вам.'
            ],
            [
                'icon' => 'fa-solid fa-utensils',
                'title' => 'Уникальные рецепты',
                'description' => 'Попробуйте наши фирменные пиццы с секретными ингредиентами.'
            ],
            [
                'icon' => 'fa-solid fa-gift',
                'title' => 'Специальные предложения',
                'description' => 'Регулярные акции и скидки для наших клиентов.'
            ],
            [
                'icon' => 'fa-solid fa-leaf',
                'title' => 'Экологичность',
                'description' => 'Мы заботимся о природе и используем экологичную упаковку.'
            ]
        ];

        $advantageCards = '';
        foreach ($advantages as $advantage) {
            $advantageCards .= <<<HTML
<div class="col-md-4 col-lg-2" data-aos="fade-up">
    <div class="card advantage-card text-center h-100">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
            <i class="{$advantage['icon']} fa-2x mb-3" style="color: #d09db0;"></i>
            <h6 class="card-title fw-bold">{$advantage['title']}</h6>
            <p class="card-text text-muted small">{$advantage['description']}</p>
        </div>
    </div>
</div>
HTML;
        }

        // Отзывы
        $reviews = [
            [
                'name' => 'Анна К.',
                'text' => 'Отличная пицца! Всегда свежая и вкусная. Рекомендую!',
                'rating' => 5
            ],
            [
                'name' => 'Иван П.',
                'text' => 'Быстрая доставка и приятные цены. Очень доволен!',
                'rating' => 4
            ],
            [
                'name' => 'Мария С.',
                'text' => 'Заказываю уже не первый раз. Качество на высоте!',
                'rating' => 5
            ]
        ];

        $reviewCards = '';
        foreach ($reviews as $review) {
            $stars = '';
            for ($i = 0; $i < $review['rating']; $i++) {
                $stars .= '<i class="fa-solid fa-star" style="color: #ffcc00;"></i>';
            }
            for ($i = $review['rating']; $i < 5; $i++) {
                $stars .= '<i class="fa-regular fa-star" style="color: #ffcc00;"></i>';
            }

            $reviewCards .= <<<HTML
<div class="col-md-4" data-aos="fade-up">
    <div class="card review-card h-100">
        <div class="card-body">
            <p class="card-text">{$review['text']}</p>
            <div class="d-flex align-items-center mt-3">
                <div class="me-2">{$stars}</div>
                <div class="fw-bold">{$review['name']}</div>
            </div>
        </div>
    </div>
</div>
HTML;
        }

        $content = <<<HTML
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9f9f9;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, rgb(208,157,176), rgb(230,180,195));
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .hero-section h1 {
        font-size: 48px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .hero-section p {
        font-size: 18px;
        margin-top: 10px;
    }

    .btn-custom {
        background: white;
        border: none;
        color: rgb(208,157,176);
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-custom:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 15px rgba(208,157,176, 0.3);
    }

    /* Advantages Section */
    .advantage-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .advantage-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Reviews Section */
    .review-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .review-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    footer {
        background-color: #2c3e50;
        color: white;
        text-align: center;
        padding: 1rem 0;
        margin-top: 3rem;
    }

    /* Анимации */
    [data-aos="fade-up"] {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    [data-aos="fade-up"].aos-animate {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<main class="container mt-5">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="text-center">
            <h1>Добро пожаловать в пиццерию!</h1>
            <p class="lead">Лучшие ингредиенты, лучший вкус.</p>
            <a href="#" class="btn btn-custom">Узнать больше</a>
        </div>
    </section>

    <!-- Advantages Section -->
    <section class="my-5">
        <h2 class="text-center mb-4">Почему выбирают нас?</h2>
        <div class="row g-4">
            {$advantageCards}
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="my-5">
        <h2 class="text-center mb-4">Отзывы наших клиентов</h2>
        <div class="row g-4">
            {$reviewCards}
        </div>
    </section>
</main>



<!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>
HTML;

        $resultTemplate = sprintf($template, 'Главная', $content);
        return $resultTemplate;
    }
}
