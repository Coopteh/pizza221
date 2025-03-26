<?php
namespace Views;

class BaseTemplate {  
    public function getBaseTemplate() {
        $template = <<<END
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>%s</title>
            <link rel="stylesheet" href="https://localhost/css/bootstrap.min.css">
        </head>
        <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-body-tertiary mb-2">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">BASIC WEB PROJECT</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="/">Главная</a>
                    <a class="nav-link active" aria-current="page" href="/list">Список урожая</a>
                    <a class="nav-link active" aria-current="page" href="/add">Добавить</a>
                    </div>               
                </div>
                </div>
            </nav>
        END;
        $template = self::getSimpleFlash($template);
        $template .= <<<END
            %s
        </div>
        </body>
        </html>
        END;
        return $template;
    }
/*
                    <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="/login">Вход</a>
                    </div>
                    <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="/users">Список пользователей</a>
                    </div>
                    <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="/add_user">Добавить пользователя</a>
                    </div>
*/

    // Добавим flash сообщение
    public static function getSimpleFlash(string $str): string 
    {
        if (isset($_SESSION['flash'])) {
            $class_alert = isset($_SESSION['flash_class']) ? $_SESSION['flash_class']: 'alert-info';
            $str .= <<<END
                <div id="liveAlertBtn" class="alert {$class_alert} alert-dismissible" role="alert">
                    <div>{$_SESSION['flash']}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                        onclick="this.parentNode.style.display='none';"></button>
                </div>
                END;
            unset($_SESSION['flash']);
            unset($_SESSION['flash_class']);
        }
        return $str;
    }
}