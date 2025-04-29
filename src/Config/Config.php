<?php

namespace App\Config;

class Config 
{
    const FILE_PRODUCTS = ".\Storage\data.json";
    const FILE_ORDERS = ".\storage\order.json";
    const TYPE_FILE = "file";
    const TYPE_DB = "db";

    // Настройки подключения
    const MYSQL_DNS = 'mysql:dbname=pizzais;host=localhost;charset=utf8';
    const MYSQL_USER = 'root';
    const MYSQL_PASSWORD = '';
    const TABLE_PRODUCTS = "products";
    const TABLE_ORDERS = "orders";

    // Режим хранения данных
    const STORAGE_TYPE = self::TYPE_DB;

    const SITE_URL = "https://localhost";

    public const CODE_STATUS = [
        "без статуса",
        "в работе",
        "доставляется",
        "завершен"
    ];

    public static function getStatusName(int $code): string {
        if (isset(self::CODE_STATUS[$code])) {
            return self::CODE_STATUS[$code];
        } else {
            throw new \InvalidArgumentException("Invalid status code: " . $code);
        }
    }

    public static function getStatusColor(int $code): string {
        $colors = [
            0 => 'text-secondary',
            1 => 'text-primary',
            2 => 'text-warning',
            3 => 'text-success'
        ];

        if (isset($colors[$code])) {
            return $colors[$code];
        } else {
            return 'text-dark';
        }
    }
}