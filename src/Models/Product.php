<?php

namespace App\Models;

use App\Configs\Config;

class Product {
    public function loadData(): ?array {
        // Открываем файл в режиме чтения
        if ($file = fopen(Config::FILE_PRODUCTS, 'r')) {
            // Считываем всё содержимое файла в переменную $data
            $data = fread($file, filesize(Config::FILE_PRODUCTS));
            // Закрываем файл
            fclose($file);
            
            // Декодируем строку JSON в ассоциативный массив
            $arr = json_decode($data, true);

            // Возвращаем полученный массив
            return $arr;
        }
        
        // Если открыть файл не удалось, возвращаем null
        return null;
    }
}