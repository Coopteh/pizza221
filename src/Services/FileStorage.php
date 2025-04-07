<?php

namespace App\Services;


class FileStorage implements IStorage, ILoadStorage, ISaveStorage
{
    public function loadData(string $name): ?array
    {
        // Проверяем, существует ли файл
        if (!file_exists($name)) {
            return null; // Если файла нет, возвращаем null
        }

        // Открываем файл для чтения
        $handle = fopen($name, "r");

        // Проверяем, удалось ли открыть файл
        if ($handle === false) {
            throw new \RuntimeException("Не удалось открыть файл для чтения: {$name}");
        }

        // Читаем содержимое файла
        $data = fread($handle, filesize($name));
        fclose($handle);

        // Декодируем JSON в массив
        $arr = json_decode($data, true);

        // Если декодирование не удалось, возвращаем null
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return $arr;
    }

    public function saveData(string $name, array $arr): bool
    {
        // Проверяем, существует ли файл
        if (!file_exists($name)) {
            // Если файла нет, создаем его и записываем пустой массив
            $allRecords = [];
        } else {
            // Если файл существует, читаем его содержимое
            $handle = fopen($name, "r");

            if ($handle === false) {
                throw new \RuntimeException("Не удалось открыть файл для чтения: {$name}");
            }

            $data = fread($handle, filesize($name));
            fclose($handle);

            // Декодируем JSON в массив
            $allRecords = json_decode($data, true);

            // Если декодирование не удалось, начинаем с пустого массива
            if (json_last_error() !== JSON_ERROR_NONE) {
                $allRecords = [];
            }
        }

        // Добавляем новые данные в массив
        $allRecords[] = $arr;

        // Кодируем массив обратно в JSON
        $json = json_encode($allRecords, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        // Записываем JSON в файл
        $handle = fopen($name, "w");

        if ($handle === false) {
            throw new \RuntimeException("Не удалось открыть файл для записи: {$name}");
        }

        fwrite($handle, $json);
        fclose($handle);

        return true;
    }
}