<?php
namespace App\Configs;

class Config
{
    // настройки подключения
    const MYSQL_DNS = 'mysql:dbname=is221;host=localhost';
    const MYSQL_USER = 'root';
    const MYSQL_PASSWORD = '';   
    const TABLE_PRODUCTS = "products";
    const TABLE_ORDERS = "orders";
    
    // Режим хранения данных 
    const TYPE_FILE = "file";
    const TYPE_DB = "db";
    const STORAGE_TYPE = self::TYPE_DB; // Установите значение по умолчанию
    
    const FILE_PRODUCTS = "./storage/data.json"; // Путь к файлу для сохранения данных о товаре
    const FILE_ORDERS = "./storage/order.json"; // Путь к файлу для сохранения заказов
    const SITE_URL="https://localhost/avtoservis";

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
            throw new InvalidArgumentException("Invalid status code: " . $code);
        }
    }

    public static function getStatusColor(int $code): string {
        switch ($code) {
            case 1:
                return 'text-warning'; // В работе
            case 2:
                return 'text-info'; // Доставляется
            case 3:
                return 'text-success'; // Завершен
            default:
                return 'text-secondary'; // Без статуса
        }
    }
}