<?php
namespace App\Services;

use App\Configs\Config;
use App\Models\Order;
use App\Services\OrderDBStorage; 

class OrderFactory 
{
    public static function createOrder(): Order 
    {
        $storage = self::createStorage();
        $storageKey = (Config::STORAGE_TYPE == Config::TYPE_FILE) 
            ? Config::FILE_ORDERS 
            : Config::TABLE_ORDERS;
        
        return new Order($storage, $storageKey);
    }

    private static function createStorage(): ISaveStorage 
    {
        return (Config::STORAGE_TYPE == Config::TYPE_FILE)
            ? new FileStorage()
            : new OrderDBStorage();
    }
}