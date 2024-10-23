<?php
namespace Routers;

use Controllers\Home;

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
        switch ($resource) {
            /*case "products":
                $product = new Product();
                if ($id)
                    $html_result = $product->get($id);
                else
                    $html_result = $product->getAll();
                break;*/
            default:
                $home = new Home();
                $html_result = $home->get();
                break;
        }
        
        return $html_result;
    }
}