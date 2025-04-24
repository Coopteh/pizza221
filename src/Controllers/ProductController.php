<?php 
namespace App\Controllers;

use App\Models\Product;
use App\Views\ProductTemplate;
use App\Services\FileStorage;
use App\Services\ProductDBStorage;
use App\Configs\Config;

class ProductController {
    public function get(?int $id): string {
        // Проверка типа хранилища и создание соответствующего объекта
        if (Config::STORAGE_TYPE == Config::TYPE_FILE) {
            $serviceStorage = new FileStorage();
            $model = new Product($serviceStorage, Config::FILE_PRODUCTS);
        } elseif (Config::STORAGE_TYPE == Config::TYPE_DB) {
            $serviceStorage = new ProductDBStorage();
            $model = new Product($serviceStorage, Config::TABLE_PRODUCTS);
        } else {
            throw new \Exception("Неизвестный тип хранилища");
        }

        $data = $model->loadData();

        // Возврат данных в зависимости от переданного ID
        if (!isset($id)) {
            return ProductTemplate::getAllTemplate($data);
        } elseif ($id > 0 && $id <= count($data) ) {
            $record = $data[$id - 1];
            return ProductTemplate::getCardTemplate($record);
        } else {
            return ProductTemplate::getCardTemplate(null);
        }
    }
}