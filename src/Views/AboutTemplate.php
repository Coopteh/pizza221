<?php

namespace App\Views;
use App\Views\BaseTemplate;

class AboutTemplate extends BaseTemplate
{
    public static function getTemplate() {
        $template = parent::getTemplate();
        $title = 'О нас';
        $content = <<<HTML

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <h1><b><strong><u><i>Кемеровский кооперативный техникум сегодня – это первый шаг на пути к будущей супер успешной карьере в айти.</i></u></strong></b></h1>
        <h3> Подготовку будущих квалифицированных специалистов осуществляет высокопрофессиональный коллектив преподавателей техникума. </h3>





     
     <div style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/64/kemerovo/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Кемерово</a><a href="https://yandex.ru/maps/64/kemerovo/house/barnaulskaya_ulitsa_31a/bEwYfw9jTUAGQFtvfX52dn1mYA==/?ll=85.984346%2C55.276263&utm_medium=mapframe&utm_source=maps&z=18" style="color:#eee;font-size:12px;position:absolute;top:14px;">Барнаульская улица, 31А — Яндекс Карты</a><iframe src="https://yandex.ru/map-widget/v1/?ll=85.984346%2C55.276263&mode=whatshere&whatshere%5Bpoint%5D=85.983503%2C55.277037&whatshere%5Bzoom%5D=17&z=18" width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>
       <br> <div style="width:560px;height:800px;overflow:hidden;position:relative;"><iframe style="width:100%;height:100%;border:1px solid #e6e6e6;border-radius:8px;box-sizing:border-box" src="https://yandex.ru/maps-reviews-widget/1019915443?comments"></iframe><a href="https://yandex.ru/maps/org/sberbank/1019915443/" target="_blank" style="box-sizing:border-box;text-decoration:none;color:#b3b3b3;font-size:10px;font-family:YS Text,sans-serif;padding:0 20px;position:absolute;bottom:8px;width:100%;text-align:center;left:0;overflow:hidden;text-overflow:ellipsis;display:block;max-height:14px;white-space:nowrap;padding:0 16px;box-sizing:border-box">СберБанк на карте Кемерова — Яндекс Карты</a></div>

HTML;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}