<?php

namespace App\Models;

use App\Services\ISaveStorage;

class Order
{
    private ISaveStorage $dataStorage;
    private string $nameResource;

    // Внедрение зависимости через конструктор
    public function __construct(ISaveStorage $service, string $name)
    {
        $this->dataStorage = $service;
        $this->nameResource = $name;
    }

    public function saveData(array $arr): bool
    {
        return $this->dataStorage->saveData($this->nameResource, $arr);
    }
}