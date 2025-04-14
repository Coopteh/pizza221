<?php
namespace App\Services;

class ValidateOrderData {
    public function validate(array $data): bool {
        // Проверка ФИО
        if (empty($data['fio'])) {
            return false;
        }

        // Проверка адреса
        if (strlen($data['address']) < 10) {
            return false;
        }

        // Проверка телефона
        if (!$this->isValidPhone($data['phone'])) {
            return false;
        }

        // Проверка email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    private function isValidPhone(string $phone): bool {
        // Пример простой проверки номера телефона
        return preg_match('/^8[0-9]{10}$/', $phone);
    }
}