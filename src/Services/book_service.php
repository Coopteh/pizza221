<?php
// Подключение к базе данных
$conn = new is221('localhost', 'username', 'password', 'database');

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение списка услуг
$sql = "SELECT productsId, name FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Запись на услугу</title>
</head>
<body>
    <h1>Запись на услугу</h1>
    <form action="confirm_booking.php" method="POST">
        <label for="service">Выберите услугу:</label>
        <select name="productsId" id="service" required>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['productsId'] . "'>" . $row['name'] . "</option>";
                }
            } else {
                echo "<option value=''>Нет доступных услуг</option>";
            }
            ?>
        </select>
        <br><br>

        <label for="date">Выберите дату и время:</label>
        <input type="datetime-local" name="bookingDate" id="date" required>
        <br><br>

        <input type="submit" value="Записаться">
    </form>
</body>
</html>

<?php
$conn->close();
?>