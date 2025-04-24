<?php 
namespace App\Configs;

class Config {
    const FILE_PRODUCTS=".\storage\data.json";
    const FILE_ORDERS=".\storage\order.json";

    const TYPE_FILE="file";
    const TYPE_DB="db";
    // Режим хранения данных (продукты и заказы)
    const STORAGE_TYPE= self::TYPE_DB;
        
    // настройки подключения
    const MYSQL_DNS = 'mysql:dbname=is-221;host=localhost';
    const MYSQL_USER = 'root';
    const MYSQL_PASSWORD = '';
    
    const TABLE_PRODUCTS="products";
    const TABLE_ORDERS="orders";

    const SITE_URL="https://localhost/gostishka";
}
