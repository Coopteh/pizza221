<?php 
namespace App\Services;

class ValidateOrderData {
    public static function validate(array $data): bool {
        // Проверка ФИО
        if (!isset($data['fio'])) {
            $_SESSION['flash'] = "Незаполнено поле ФИО.";
            return false;
        }
    
        // Проверка адреса
        if (!isset($data['address']) || 
            strlen(trim($data['address'])) < 10 || 
            strlen(trim($data['address'])) > 200) {
            $_SESSION['flash'] = "Поле адреса должно быть более 10 символов (но не более 200).";
            return false;
        }
    
        // Проверка телефона
        if (!isset($data['phone'])) {
            $_SESSION['flash'] = "Незаполнено поле Телефон.";
            return false;
        }
        $cleanedPhone = preg_replace('/[^\\d]/', '', $data['phone']);
        if (strlen($cleanedPhone) !== 11 || 
            !in_array($cleanedPhone[0], ['7', '8'])) {
            $_SESSION['flash'] = "Неверный номер телефона.";
            return false;
        }
    
        // Проверка email
        if (!isset($data['email']) || 
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash'] = "Неправильно заполнено поле Емайл.";
            return false;
        }
    
        return true;
    }
}
