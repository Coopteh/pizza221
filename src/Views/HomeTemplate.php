<?php
namespace App\Views;
use App\Views\BaseTemplate;
class  HomeTemplate extends BaseTemplate
{
    public static function getTemplate(): string
    {
        $template = parent::getTemplate();
        $title= 'Главная страница';
        $content = <<<CORUSEL
        <section>
        <div class = "h-50 w-50 mx-auto">
        <div id="carouselExample" class="carousel slide">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src=".\assets\images\img1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src=".\assets\images\img2.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src=".\assets\images\img3.jpg" class="d-block w-100" alt="...">
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
CORUSEL;
        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }
}