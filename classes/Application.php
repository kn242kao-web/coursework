<?php
class Application {
    public function run(): void {
        $controllerName = ucfirst($_GET['controller'] ?? 'index') . 'Controller';
        $actionName = 'action_' . ($_GET['action'] ?? 'main');

        if (!class_exists($controllerName)) {
            $this->show404("Контролер $controllerName не знайдено.");
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $actionName)) {
            $this->show404("Дія $actionName не знайдена.");
            return;
        }

        $controller->$actionName();
    }

    private function show404($msg): void {
        http_response_code(404);
        $view = new PageView();
        $view->setTitle("404 - Не знайдено");
        $view->render('layout/404', ['message' => $msg]);
    }
}