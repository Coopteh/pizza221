<?php

namespace App\Configs;

class Config
{
    const TYPE_FILE="file";
    const TYPE_DB="db";
    const STORAGE_TYPE= self::TYPE_FILE;
    const FILE_PRODUCTS = "./storage/data.json";// Путь к файлу для сохранения данных о товаре
    const FILE_ORDERS = "./storage/order.json"; // Путь к файлу для сохранения заказов
}
