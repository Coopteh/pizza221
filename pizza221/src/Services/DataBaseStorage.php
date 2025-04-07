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

use PDO;
use App\Configs\Config;

class DBStorage 
{
    protected $connection;

    public function __construct() {
        // устанавливаем соединение
        $this->connection = new PDO(
            Config::MYSQL_DNS,
            Config::MYSQL_USER,
            Config::MYSQL_PASSWORD
        );
    }
}