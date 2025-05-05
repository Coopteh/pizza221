<?php
$router = new \App\Router\Router();

// Для Closure (анонимной функции)
$router->register('/test-update', function() {
    $storage = new \App\Services\UserDBStorage();
    $testData = [/* данные */];
    $result = $storage->updateProfile(1, $testData);
    return $result ? 'Success' : 'Failed';
});

// ИЛИ для контроллера (предпочтительный способ)
//$router->register('/test-update', [TestController::class, 'updateTest'], ['GET']);

// Новые маршруты (регистрируются через register())
$router->register('/avtoservis/confirm_booking', [OrderController::class, 'confirmBooking'], ['POST']);
$router->register('/avtoservis/history', [OrderController::class, 'history']);
$router->register('/avtoservis/profile', [UserController::class, 'updateProfile'], ['POST']);
$router->register('/', [HomeController::class, 'get']);
$router->register('/avtoservis/', [HomeController::class, 'get']);

// Старые маршруты будут работать через handleLegacyRoute()
return $router;
