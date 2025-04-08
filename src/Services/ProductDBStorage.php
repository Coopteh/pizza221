<?php 
namespace App\Services;

use PDO;

class ProductDBStorage extends DataBaseStorage implements ILoadStorage
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