<?php
class OrderNotifier {
    public function notify($message) {
        printf("Уведомление отправлено: %s\n", $message);
    }
}