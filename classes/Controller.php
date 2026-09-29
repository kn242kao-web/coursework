<?php

class Controller
{
    protected Request $request;
    protected PageView $view;

    public function __construct()
    {
        $this->request = new Request();
        $this->view = new PageView();
    }

    protected function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function redirect(string $controller, string $action = 'main'): void
    {
        header('Location: index.php?route=' . $controller . '/' . $action);
        exit;
    }
}