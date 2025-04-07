<?php
namespace App\Services;

class DatabaseStorage implements IStorage
{
    public function loadData(string $name): ?array
    {
        // оставьте метод пустым, мы напишем реализацию позже
        return [];
    }
    public function saveData(string $name, array $data): bool
    {
        // оставьте метод пустым, мы напишем реализацию позже
        return true;
    }
}

