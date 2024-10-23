<?php
namespace Controllers;

use Models\UserDBStorage;
use Views\UserTemplate;

class Users {
    public function get(): string 
    {
        $objTemplate = new UserTemplate();
        $template = $objTemplate->getLoginTemplate();
        return $template;
    }

    public function auth($login,$password)
    {
        $storage = new UserDBStorage();
        $result = $storage->getUser($login,$password);
        return $result;
    }

    public function getAll(): string 
    {
        $objTemplate = new UserTemplate();
        $storage = new UserDBStorage();
        $result = $storage->getAllUsers();
        $template = $objTemplate->getUsersTemplate($result);
        return $template;
    }    

    public function addUser($row)
    {
        $storage = new UserDBStorage();
        $result = $storage->addUser($row);
        return $result;
    }

    public function getForm() {
        $objTemplate = new UserTemplate();
        $template = $objTemplate->getFormTemplate();
        return $template;
    }
}