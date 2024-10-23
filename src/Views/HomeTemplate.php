<?php
namespace Views;

use Views\BaseTemplate;

class HomeTemplate extends BaseTemplate {
    public function getHomeTemplate(): string 
    {
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <div class="row mt-5">
            <p>
                Базовый проект
            </p>
        </div>   
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        END;
        $resultTemplate =  sprintf($template, 'Главная страница', $str);
        return $resultTemplate;
    }
}