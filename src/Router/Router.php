<?php
namespace App\Router;

use App\Controllers\AboutController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\BasketController;
use App\Controllers\OrderController;
use App\Controllers\RegisterController;
use App\Controllers\UserController;
use App\Controllers\AppointmentController;

class Router {
    private array $routes = [];

    public function register(string $uri, $handler, array $methods = ['GET']): void {
        if (!is_array($handler) && !$handler instanceof \Closure) {
            throw new \InvalidArgumentException('Handler must be array or Closure');
        }
        $this->routes[] = [
            'uri' => $uri,
            'handler' => $handler, // Может быть как массивом, так и Closure
            'methods' => $methods
        ];
    }

    public function route(string $url): string {
        $path = parse_url($url, PHP_URL_PATH) ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];
    
        foreach ($this->routes as $route) {
            if ($this->matchRoute($path, $route['uri']) && in_array($method, $route['methods'])) {
                if ($route['handler'] instanceof \Closure) {
                    return $route['handler']();
                }
                return $this->callControllerAction($route['handler'][0], $route['handler'][1]);
            }
        }
        return $this->handleLegacyRoute($path);
    }

    private function matchRoute(string $path, string $routeUri): bool {
        return $path === $routeUri;
    }

    private function callControllerAction(string $controllerClass, string $action): string {
        try {
            $fullClassName = "App\\Controllers\\" . $controllerClass;
            
            if (!class_exists($fullClassName)) {
                throw new \RuntimeException("Controller {$fullClassName} not found");
            }
        
            $controller = new $fullClassName();
            
            if (!method_exists($controller, $action)) {
                header("HTTP/1.0 404 Not Found");
                return $this->renderErrorPage(404, "Страница не найдена");
            }
            
            return $controller->$action();
        } catch (\Exception $e) {
            error_log("Routing error: " . $e->getMessage());
            header("HTTP/1.0 500 Internal Server Error");
            return $this->renderErrorPage(500, "Внутренняя ошибка сервера: " . $e->getMessage());
        }
    }

    private function handleLegacyRoute(string $path): string {
        $pieces = explode("/", $path);
        $resource = $pieces[2] ?? null;
    
        switch ($resource) {
            case "about":
                return (new AboutController())->get();
            case "order":
                return (new OrderController())->get();
            case "register":
                return (new RegisterController())->get();
            case "profile":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        return (new UserController())->updateProfile();
                }
                return (new UserController())->profile();
            case "verify":
                $token = $pieces[3] ?? null;
                return (new RegisterController())->verify($token);
            case "login":
                return (new UserController())->handleLoginRequest();
            case "logout":
                unset($_SESSION['user_id'], $_SESSION['username']);
                session_destroy();
                header("Location: /avtoservis/");
                return "";
            case 'basket_clear':
                (new BasketController())->clear();
                header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/'));
                return '';
            case "products":
                $id = $pieces[3] ?? null;
                return (new ProductController())->get($id);
            case "basket":
                (new BasketController())->add();
                header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/'));
                return "";
            case "select_time":
                return (new OrderController())->selectTime();
            case "confirm_booking":
                return (new OrderController())->confirmBooking();
            case "history":
                return (new AppointmentController())->getHistory();
            case "debug_basket":
                header('Content-Type: application/json');
                die(json_encode([
                    'session_id' => session_id(),
                    'basket' => $_SESSION['basket'] ?? null,
                    'session' => $_SESSION
                ], JSON_PRETTY_PRINT));
            default:
                header("HTTP/1.0 404 Not Found");
                return $this->renderErrorPage(404, "Страница не найдена");
        }
    }

    private function renderErrorPage(int $code, string $message): string {
        return sprintf(
            '<!DOCTYPE html>
            <html>
            <head>
                <title>Ошибка %d</title>
                <meta charset="UTF-8">
                <style>
                    body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                    h1 { color:rgb(67, 16, 207); }
                </style>
            </head>
            <body>
                <h1>Ошибка %d</h1>
                <p>%s</p>
                <a href="/avtoservis/">Вернуться на главную</a>
            </body>
            </html>',
            $code,
            $code,
            htmlspecialchars($message)
        );
    }
}