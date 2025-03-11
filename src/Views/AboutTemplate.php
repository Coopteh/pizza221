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
        <h3> Подготовку будущих квалифицированных специалистов осуществляет высокопрофессиональный коллектив преподавателей техникума. </h3>
HTML;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}