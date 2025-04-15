<?php 
namespace App\Services;

interface ILoadStorage
{
    public function loadData(string $name): ?array;
}
