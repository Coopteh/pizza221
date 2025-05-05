<?php
session_start();

error_log("User ID: " . $_SESSION['user_id'] ?? 'null');
error_log("Booking data: " . print_r($_POST, true));

// Проверка, были ли отправлены данные из формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $fio = $_POST['fio'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $bookingDate = $_POST['bookingDate']; // Получаем дату и время записи

    // Подключение к базе данных
    $conn = new mysqli('localhost', 'username', 'password', 'database');

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Подготовка SQL-запроса для вставки данных
    $stmt = $conn->prepare("INSERT INTO bookings (fio, address, phone, email, bookingDate, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fio, $address, $phone, $email, $bookingDate);

    // Выполнение запроса и проверка на ошибки
    if ($stmt->execute()) {
        $_SESSION['flash'] = "Запись успешно создана!"; // Устанавливаем флэш-сообщение
    } else {
        $_SESSION['flash'] = "Ошибка: " . $stmt->error; // Устанавливаем сообщение об ошибке
    }

    // Закрытие соединения
    $stmt->close();
    $conn->close();

    // Перенаправление на страницу с сообщением
    header("Location: /avtoservis/order");
    exit;
} else {
    // Если данные не были отправлены, перенаправляем обратно
    header('Location: /avtoservis/order'); // или на страницу с корзиной
    exit;
}