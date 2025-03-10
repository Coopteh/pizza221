<?php
namespace App\Views;
class HomeTemplate extends BaseTemplate {
    
    public static function getTemplate():string {
        $template = parent::getTemplate();
        $title= 'Главная страница';
        $content = <<<LINE
<section>  
<div class="h-50 w-50mx-auto">             
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carusel">
  <div class="carousel-inner" style="height:50vh">
    <div class="carousel-item active">
      <img src="./assets/images/img1.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./assets/images/img2.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="./assets/images/img3.png" class="d-block w-100" alt="...">
    </div>
  </div>
</section>  
LINE;

        $template =  sprintf($template, $title, $content);
        return $template;
    }
}