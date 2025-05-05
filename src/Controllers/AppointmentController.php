<?php
namespace App\Controllers;  // Должно совпадать с use в Router.php

use App\Services\UserDBStorage;
use App\Views\UserTemplate;

class AppointmentController {
    private UserDBStorage $userStorage;

    public function __construct() {
        $this->userStorage = new UserDBStorage();
    }

    public function bookAppointment(): string {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['flash'] = "Вы должны быть авторизованы для записи.";
                header("Location: /avtoservis/login");
                exit;
            }

            try {
                $data = $this->validateAppointmentData($_POST);
                
                if ($this->userStorage->isSlotAvailable($data['date'], $data['time'])) {
                    if ($this->userStorage->saveAppointment($data)) {
                        $_SESSION['flash'] = "Запись успешно создана!";
                        header("Location: /avtoservis/orders");
                        exit;
                    } else {
                        $_SESSION['flash'] = "Ошибка при создании записи.";
                    }
                } else {
                    $_SESSION['flash'] = "Выбранное время уже занято. Пожалуйста, выберите другое время.";
                }
            } catch (\InvalidArgumentException $e) {
                $_SESSION['flash'] = $e->getMessage();
            }
        }

        $availableSlots = $this->userStorage->getAvailableSlots();
        return UserTemplate::getBookingTemplate($availableSlots);
    }

    public function getHistory(): string {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = "Для просмотра истории войдите в систему";
            header("Location: /avtoservis/login");
            exit;
        }
    
        $history = $this->userStorage->getUserHistory($_SESSION['user_id']);
        return UserTemplate::getHistoryTemplate($history);
    }

    public function cancelAppointment(int $appointmentId): void {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = "Для отмены записи войдите в систему";
            header("Location: /avtoservis/login");
            exit;
        }

        if ($this->userStorage->cancelAppointment($_SESSION['user_id'], $appointmentId)) {
            $_SESSION['flash'] = "Запись успешно отменена";
        } else {
            $_SESSION['flash'] = "Не удалось отменить запись";
        }
        
        header("Location: /avtoservis/history");
        exit;
    }

    private function validateAppointmentData(array $postData): array {
        return [
            'user_id' => $_SESSION['user_id'],
            'date' => $this->sanitizeDate($postData['date']),
            'time' => $this->sanitizeTime($postData['time']),
            'service_type' => $this->sanitizeText($postData['service_type'] ?? ''),
            'comments' => $this->sanitizeText($postData['comments'] ?? '')
        ];
    }

    private function sanitizeDate(string $date): string {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            throw new \InvalidArgumentException("Некорректный формат даты");
        }
        return strip_tags($date);
    }

    private function sanitizeTime(string $time): string {
        if (!preg_match('/^\d{2}:\d{2}$/', $time)) {
            throw new \InvalidArgumentException("Некорректный формат времени");
        }
        return strip_tags($time);
    }

    private function sanitizeText(string $text): string {
        return htmlspecialchars(strip_tags($text), ENT_QUOTES, 'UTF-8');
    }
}