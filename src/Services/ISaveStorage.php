<?php 
namespace App\Services;

interface ISaveStorage
{
    public function saveData(string $name, array $data): bool;
}