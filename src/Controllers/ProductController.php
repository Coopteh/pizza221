<?php 
namespace App\Controllers;

use App\Models\Product;
use App\Views\ProductTemplate;
use App\Services\FileStorage;
use App\Services\DatabaseStorage;
use App\Config\Config;

class ProductController {
    public function get(?int $id): string {

        // Определяем тип хранилища
        if (Config::STORAGE_TYPE == Config::TYPE_FILE) {
            $serviceStorage = new FileStorage();
            $model = new Product($serviceStorage, Config::FILE_PRODUCTS);
        } else {
            // Здесь можно добавить поддержку других типов хранилищ, например, DatabaseStorage
            return "Тип хранилища не поддерживается.";
        }

        // Загружаем данные
        $data = $model->loadData();

        // Проверяем, что данные успешно загружены
        if ($data === null || !is_array($data)) {
            return "Ошибка загрузки данных.";
        }

        // Если ID не указан, возвращаем все товары
        if (!isset($id)) {
            return ProductTemplate::getAllTemplate($data);
        }

        // Если ID указан, проверяем его корректность
        if (($id) && ($id <= count($data))) {
            $record = $data[$id - 1];
            return ProductTemplate::getCardTemplate($record);
        } else {
            return ProductTemplate::getCardTemplate(null);
        }
    }
}