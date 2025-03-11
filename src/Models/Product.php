<?php 
namespace App\Models;

use App\Configs\Config;

class Product {
    public function loadData(): ?array {
        $nameFile= Config::FILE_PRODUCTS;
        
        $handle = fopen($nameFile, "r");
        $data = fread($handle, filesize($nameFile)); 
        fclose($handle);

        $arr = json_decode($data, true); 
        
        return $arr; 
    }
}