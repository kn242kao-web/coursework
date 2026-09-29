<?php
require_once __DIR__ . '/config/init.php';
$router = new Router();
$routeData = $router->parseRoute();
$controllerName = ucfirst($routeData['controller']) . 'Controller';
$actionName = 'action_' . $routeData['action'];

if (class_exists($controllerName)) {
    $controllerInstance = new $controllerName();
    
    if (method_exists($controllerInstance, $actionName)) {
        $controllerInstance->$actionName();
    } else {
        http_response_code(404);
        die("Помилка 404: Метод дії '{$actionName}' не знайдено в класі '{$controllerName}'.");
    }
} else {
    http_response_code(404);
    die("Помилка 404: Клас контролера '{$controllerName}' не існує.");
}