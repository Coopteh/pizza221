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
    const MYSQL_DNS = 'mysql:dbname=is221;host=localhost';
    const MYSQL_USER = 'root';
    const MYSQL_PASSWORD = '';
    
    const TABLE_PRODUCTS="products";
    const TABLE_ORDERS="orders";

    const SITE_URL="https://localhost/pizza221";

    public const CODE_STATUS = [
        "без статуса",
        "в работе",
        "доставляется",
        "завершен"
    ];
    public const CODE_STATUS_COLOR = [
        "text-white",
        "text-primary",
        "text-warning",
        "text-success"
    ];
    
    public static function getStatusName(int $code): string {
        if (isset(self::CODE_STATUS[$code])) {
            return self::CODE_STATUS[$code];
        } else {
            throw new \InvalidArgumentException("Invalid status code: " . $code);
        }
    }

    public static function getStatusColor(int $code): string {
        if (isset(self::CODE_STATUS_COLOR[$code])) {
            return self::CODE_STATUS_COLOR[$code];
        } else {
            throw new \InvalidArgumentException("Invalid status code: " . $code);
        }
    }    
}
