<?php 

namespace App\Services;

use App\Services\DBStorage;
use App\Services\ILoadStorage;
use PDO;

class ProductDBStorage extends DBStorage implements ILoadStorage
{
    public function loadData($nameFile): ?array
    {
        $sql = "SELECT `id`, `name`, `description`, `image`, `price`
                  FROM products";
        $result = $this->connection->query($sql, PDO::FETCH_ASSOC);
        $rows = $result->fetchAll();
        return $rows; 
    }
}