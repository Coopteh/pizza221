<?php

namespace App\Services;

use App\Configs\Config;
use App\Models\Product;

class ProductFactory {

    public static function createProduct():Product {
        if (Config::STORAGE_TYPE == Config::TYPE_FILE) {
            $serviceStorage = new FileStorage();
            $model = new Product($serviceStorage, Config::FILE_PRODUCTS);
        }
        if (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $serviceStorage = new ProductDBStorage();
            $model = new Product($serviceStorage, Config::TABLE_PRODUCTS);
        }
        return $model;
    }

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

