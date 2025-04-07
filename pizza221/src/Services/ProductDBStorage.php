<?php
namespace App\Services;

use PDO;

class ProductDBStorage extends DBStorage implements ILoadStorage
{
    public function loadData($nameFile): ?array
    {
        // SQL-запрос для получения всех полей из таблицы products
        $sql = "SELECT * FROM products"; // Замените * на конкретные поля, если нужно

        try {
            // Выполняем запрос и получаем результат
            $result = $this->connection->query($sql);
            
            // Получаем все строки результата в виде ассоциативного массива
            $rows = $result->fetchAll(PDO::FETCH_ASSOC);
            
            return $rows; 
        } catch (PDOException $e) {
            // Обработка ошибок, если запрос не удался
            echo "Error fetching data: " . $e->getMessage();
            return null; // Возвращаем null в случае ошибки
        }
    }
}