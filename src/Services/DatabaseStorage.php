<?php
namespace App\Services;

use PDO;
use App\Configs\Config;

class DataBaseStorage 
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