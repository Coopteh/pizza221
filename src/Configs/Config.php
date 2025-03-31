<?php 
namespace App\Configs;

class Config {
    const FILE_PRODUCTS=".\storage\data.json";
    const FILE_ORDERS=".\storage\order.json";

    const TYPE_FILE="file";
    const TYPE_DB="db";
    // Режим хранения данных (продукты и заказы)
    const STORAGE_TYPE= self::TYPE_FILE;
}