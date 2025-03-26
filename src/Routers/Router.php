<?php
namespace Routers;

use Controllers\Home;
use Controllers\Users;

class Router {
    public function route(string $url):?string 
    {
        $path = parse_url($url, PHP_URL_PATH);  
        //     /products/12

        $pieces = explode("/", $path);          
        // [0]- пусто, [1]- products, [2]- 12
        
        $id = 0;
        // Идентификатор найден
        if (isset($pieces[2]) && !empty($pieces[2])) {
            $id = intval($pieces[2]);
        }
        // метод GET, POST, DELETE
    	$method = $_SERVER['REQUEST_METHOD'];

        $resource = $pieces[1];
        $html_result = "";
        session_start();

        switch ($resource) 
        {
            case 'list':
                $userController = new Users();
                $html_result = $userController->getALLUsers();
            break;
            case 'add':
                $userController = new Users();
                if (isset($_POST['name']) && isset($_POST['quantity'])) {
                    $row= array(
                        'name' => $_POST['name'],
                        'quantity' => $_POST['quantity'],
                        'created_at' => date("Y-m-d H:m:s",strtotime($_POST['created_at'])),
                    );
                
                    if ($userController->add($row)) {
                        self::addFlash("Успешно пройдена аутентификация пользователя");
                        header('Location: /');
                        return '';
                    } else {
                        self::addFlash("Такого пользователя нет в БД", "alert-danger");
                    }
                }
                $html_result = $userController->getForm();
                break;
            default:
                $home = new Home();
                $html_result = $home->get();
                break;
        }
        
        return $html_result;
    }

    public static function addFlash($str, $type='alert-info') 
    {
        $_SESSION['flash'] = $str;
        $_SESSION['flash_class'] = $type;
    }
}