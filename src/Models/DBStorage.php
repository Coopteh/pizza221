<?php
namespace Models;

use PDO;

class DBStorage 
{
    const DNS = 'mysql:dbname=burgerkrig;host=localhost';
    const USER = 'root';
    const PASSWORD = '';

    protected $connection;

    public function __construct(){
        // устанавливаем соединение
        $this->connection = new PDO(self::DNS, self::USER, self::PASSWORD);
    }
}
