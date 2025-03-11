<?php

namespace App\Views;
use App\Views\BaseTemplate;

class HomeTemplate extends BaseTemplate
{
    public static function getTemplate() {
        $template = parent::getTemplate();
        $title = 'Главная страница';
        $content = <<<HTML

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/assets/image/1.png" class="d-block w-35" alt="Первый слайд">
                </div>
                <div class="carousel-item">
                    <img src="/assets/image/2.png" class="d-block w-35" alt="Второй слайд">
                </div>
                <div class="carousel-item">
                    <img src="/assets/image/3.png" class="d-block w-35" alt="Третий слайд">
                </div>
            </div>
      
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <h1><b><strong><u><i>Крутая пицца</i></u></strong></b></h1>
HTML;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}