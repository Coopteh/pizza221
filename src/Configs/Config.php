<?php
namespace App\Configs;
use InvalidArgumentException;

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
    const SITE_URL="https://localhost/pizza221";
    public const CODE_STATUS = [
        "без статуса",
        "в работе",
        "доставляется",
        "завершен"
    ];
    public const STATUS_COLORS = [
        "text-muted", // без статуса
        "text-warning", // в работе
        "text-info", // доставляется
        "text-success" // завершен
    ];
    
    public static function getStatusName(int $code): string {
        if (isset(self::CODE_STATUS[$code])) {
            return self::CODE_STATUS[$code];
        } else {
            throw new InvalidArgumentException("Invalid status code: " . $code);
        }
    }
    public static function getStatusColor(int $code): string {
        if (isset(self::STATUS_COLORS[$code])) {
            return self::STATUS_COLORS[$code];
        } else {
            return "text-muted"; // Цвет по умолчанию, если статус не найден
        }
    }
}