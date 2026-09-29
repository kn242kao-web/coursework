<?php
class Router
{
    private string $defaultController = 'index';
    private string $defaultAction = 'main';

    public function parseRoute(): array
    {
        $route = $_GET['route'] ?? '';
        
        if ($route !== '') {
            $parts = explode('/', $route);
            $controller = $parts[0] ?? $this->defaultController;
            $action = $parts[1] ?? $this->defaultAction;
        } else {
            $controller = $_GET['c'] ?? $this->defaultController;
            $action = $_GET['a'] ?? $this->defaultAction;
        }

        $controller = preg_replace('/[^a-zA-Z0-9]/', '', $controller);
        $action = preg_replace('/[^a-zA-Z0-9_]/', '', $action);

        return [
            'controller' => strtolower($controller),
            'action'     => strtolower($action),
        ];
    }
}