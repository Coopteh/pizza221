<?php 
namespace App\Services;

class ValidateOrderData {
    public static function validate(array $data): bool {
        // Проверка ФИО
        if (empty($data['fio'])) {
            $_SESSION['flash'] = "Незаполнено поле ФИО.";
            return false;
        }

        // Проверка адреса
        if (empty($data['address']) || 
            strlen(trim($data['address'])) < 10 || 
            strlen(trim($data['address'])) > 200) { 
            $_SESSION['flash'] = "Поле адреса должно быть более 10 символов (но не более 200).";
            return false;
        }

        // Проверка телефона
        if (empty($data['phone'])) {
            $_SESSION['flash'] = "Незаполнено поле Телефон.";
            return false;
        }
        $cleanedPhone = preg_replace('/[^\\d]/', '', $data['phone']);
        if (strlen($cleanedPhone) !== 11 || 
            !in_array($cleanedPhone[0], ['7', '8'])) {
            $_SESSION['flash'] = "Неверный номер телефона. Он должен начинаться с 7 или 8 и содержать 11 цифр.";
            return false;
        }

        // Проверка email
        if (empty($data['email']) || 
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash'] = "Неправильно заполнено поле E-mail.";
            return false;
        }

        return true;
    }
}