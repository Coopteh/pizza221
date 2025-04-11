<?php
namespace App\Services;

use App\Configs\Config;
use App\Models\Order;

class OrderFactory {

    public static function createOrder(): Order {
        if (Config::STORAGE_TYPE == Config::TYPE_FILE) {
            $serviceStorage = new FileStorage();
            $orderModel = new Order($serviceStorage, Config::FILE_ORDERS);
        }
        if (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $serviceStorage = new OrderDBStorage();
            $orderModel = new Order($serviceStorage, Config::TABLE_ORDERS);
        }
        return $orderModel;
    }

}