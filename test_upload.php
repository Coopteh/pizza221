<?php
$file = 'D:/xampp/htdocs/avtoservis/assets/uploads/test.txt';
file_put_contents($file, 'Test');
echo file_exists($file) ? "Успешно!" : "Ошибка!";