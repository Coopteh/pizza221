<?php
namespace App\Views;
class HomeTemplate extends BaseTemplate {
    
    public static function getTemplate():string {
        $template = parent::getTemplate();   
        $title = 'Главная страница';
        $content = '<div id="carouselExample" class="carousel slide">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./assets/images/t3.png" class="d-block w-100" alt="..." width="64" height="64">
    </div>
    <div class="carousel-item">
      <img src="./assets/images/t1.png" class="d-block w-100" alt="..." width="64" height="64">
    </div>
    <div class="carousel-item">
      <img src="./assets/images/t2.png" class="d-block w-100" alt="..." width="64" height="64">
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
</div>';
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
    
}