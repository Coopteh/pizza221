<?php

namespace App\Views;

use App\Views\BaseTemplate;

class HomeTemplate extends BaseTemplate {
    public static function getTemplate() {
        $template = parent::getTemplate(); 
        $title = 'Главная страница'; 
        $content = <<<Corusel
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="https://localhost/AutoParts/assets/images/Auto1.jpg" class="d-block w-100vh" alt="...">
            </div>
            <div class="carousel-item">
            <img src="https://localhost/AutoParts/assets/images/Auto2.jpg" class="d-block w-100vh" alt="...">
            </div>
            <div class="carousel-item">
            <img src="https://localhost/AutoParts/assets/images/Auto3.jpg" class="d-block w-100vh" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
        <div>
        <p>Здесь можно заказать пиццу с доставкой по городу Кемерово.</p>
        <p>Широкий ассортимент, низкие цены, быстрая доставка!</p>

        <p>Сайт разработан в рамках обучения в "Кузбасском кооперативном техникуме" по специальности "Специалист по информационным технологиям".</p>
        </div>
Corusel; 
        $resultTemplate = sprintf($template, $title, $content); 
        return $resultTemplate; 
    }
}

