<?php
namespace App\Views;

class HomeTemplate extends BaseTemplate {
    public static function getTemplate() : string  {
        $template = parent::getTemplate();
        $title = 'Главная страница';
        
        $content = '<section>
            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQFctgRAyDdsRakBMQD8cqrdpuLkbp6BQvHww&s" class="d-block w-50" alt="Первый слайд">
                    </div>
                    <div class="carousel-item">
                        <img src="https://www.f1cd.ru/news/input/2009/12/input_62_5.jpg" class="d-block w-50" alt="Второй слайд">
                    </div>
                    <div class="carousel-item">
                        <img src="https://sotni.ru/wp-content/uploads/2023/08/smeshnoi-kompiuter-1.webp" class="d-block w-50" alt="Третий слайд">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
        <main>
            <p>Здесь можно</p>
            <p>(*) Сайт разработан в рамках обучения в "Кузбасском кооперативном техникуме" по специальности "Специалист по информационным технологиям".</p>
        </main>';
        
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}
