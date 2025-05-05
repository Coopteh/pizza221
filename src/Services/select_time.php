<?php
session_start();

// Проверка, были ли отправлены данные из формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Сохраняем данные пользователя в сессии
    $_SESSION['order_data'] = [
        'fio' => $_POST['fio'],
        'address' => $_POST['address'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
    ];
} else {
    // Если данные не были отправлены, перенаправляем обратно
    header('Location: /avtoservis/order'); // или на страницу с корзиной
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Выбор времени записи</title>
</head>
<body>
    <h1>Выбор времени записи</h1>
    <form action="/avtoservis/confirm_booking" method="POST">
        <label for="date">Выберите дату и время:</label>
        <input type="datetime-local" name="bookingDate" id="date" required>
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($_SESSION['order_data']['username']); ?>">
        <input type="hidden" name="address" value="<?php echo htmlspecialchars($_SESSION['order_data']['address']); ?>">
        <input type="hidden" name="phone" value="<?php echo htmlspecialchars($_SESSION['order_data']['phone']); ?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['order_data']['email']); ?>">
        <button type="submit" class="btn btn-primary">Записаться</button>
    </form>
</body>
</html>