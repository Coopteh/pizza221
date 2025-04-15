<?php
namespace Models;

use PDO;

class UserDBStorage extends DBStorage
{
    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }

    public function add($row) {
        $sql = "INSERT INTO `users`(`name`, `quantity`, `created_at`) 
        VALUES ('".$row['name']."','".$row['quantity']."','".$row['created_at']."')";
        $result = $this->connection->query($sql);
        return $result;
    }
}
