<?php
namespace Models;

use PDO;

class UserDBStorage extends DBStorage
{
    public function getUser($login, $password) {
        $sql = "SELECT * FROM users WHERE login='".$login."' and password='".$password."'";
        $result = $this->connection->query($sql);
        $row = $result->fetch();
        return $row;
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $result = $this->connection->query($sql);
        $rows = $result->fetchAll();
        return $rows;
    }

    public function addUser($row) {
        $sql = "INSERT INTO `users`(`login`, `password`, `role`) 
        VALUES ('".$row['login']."','".$row['password']."','".$row['role']."')";
        $result = $this->connection->query($sql);
        return $result;
    }
}
