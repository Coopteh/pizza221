<?php
namespace App\Configs;

class Config
{
    // настройки подключения
    const MYSQL_DNS = 'mysql:dbname=is221;host=localhost;charset=utf8';
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
}