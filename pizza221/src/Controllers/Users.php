<?php
namespace Controllers;

use Models\UserDBStorage;
use Views\UserTemplate;

class Users {
    public function getALLUsers(): string 
    {
        $objTemplate = new UserTemplate();
        $storage = new UserDBStorage();
        $result = $storage->getAllUsers();
        $template = $objTemplate->getUsersTemplate($result);
        return $template;
    }
public function add($row)
{
    $storage = new UserDBStorage();
    $result = $storage->add($row);
    return $result;
}

public function getForm() {
    $objTemplate = new UserTemplate();
    $template = $objTemplate->getFormTemplate();
    return $template;
}
}