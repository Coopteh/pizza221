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

        <h1><b><strong><u><i>Кемеровский кооперативный техникум сегодня – это первый шаг на пути к будущей успешной карьере.</i></u></strong></b></h1>
        <h3><br> Подготовку будущих квалифицированных специалистов осуществляет высокопрофессиональный коллектив преподавателей техникума. </br></h3>
        <h4>Мы на карте.</br></h4>
        <br><div style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/org/kemerovskiy_kooperativny_tekhnikum/1018378103/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Кемеровский кооперативный техникум</a><a href="https://yandex.ru/maps/64/kemerovo/category/technical_college/184106244/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:14px;">Техникум в Кемерове</a><a href="https://yandex.ru/maps/64/kemerovo/category/further_education/184106162/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:28px;">Дополнительное образование в Кемерове</a><iframe src="https://yandex.ru/map-widget/v1/?ll=86.133386%2C55.332456&mode=poi&poi%5Bpoint%5D=86.133796%2C55.333990&poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D1018378103&z=17.14" width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div></br>
        <br><div style="width:560px;height:800px;overflow:hidden;position:relative;"><iframe style="width:100%;height:100%;border:1px solid #e6e6e6;border-radius:8px;box-sizing:border-box" src="https://yandex.ru/maps-reviews-widget/1018378103?comments"></iframe><a href="https://yandex.ru/maps/org/kemerovskiy_kooperativny_tekhnikum/1018378103/" target="_blank" style="box-sizing:border-box;text-decoration:none;color:#b3b3b3;font-size:10px;font-family:YS Text,sans-serif;padding:0 20px;position:absolute;bottom:8px;width:100%;text-align:center;left:0;overflow:hidden;text-overflow:ellipsis;display:block;max-height:14px;white-space:nowrap;padding:0 16px;box-sizing:border-box">Кемеровский кооперативный техникум на карте Кемерова — Яндекс Карты</br></a></div>
HTML;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}