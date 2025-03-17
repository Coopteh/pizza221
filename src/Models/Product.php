<?php
namespace App\Models;
use App\Config\Config;

class Product {

    public function loadData(): ?array
    {
     $file = fopen(Config::FILE_PRODUCTS, 'r');
        if (!$file) {
         return null;
     
        }
$data = fread($file,filesize(Config::FILE_PRODUCTS));
fclose($file);
$arr = json_decode($data, true);
        return $arr;

    }
}