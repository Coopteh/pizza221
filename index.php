<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

// Инициализация глобальных переменных из сессии
$user_id = $_SESSION['user_id'] ?? 0;
$username = $_SESSION['username'] ?? '';

// Настройки отображения ошибок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Инициализация маршрутизатора
$router = require __DIR__ . '/src/Routes.php';
echo $router->route($_SERVER['REQUEST_URI']);
error_log('Session ID: ' . session_id());
error_log("Request URI: " . $_SERVER['REQUEST_URI']);
error_log("Path: " . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));