<?php
class IndexController extends PageController
{
    public function action_main(): void
    {
        if (isset($_SESSION['user_login']) && !isset($_COOKIE['user_name'])) {
            setcookie('user_name', $_SESSION['user_login'], time() + (30 * 24 * 60 * 60), "/");
        }

        if ($this->request->isPost() && $this->request->post('set_bg')) {
            $newColor = $this->request->post('bg_color');
            
            $allowedColors = ['#4a6fa5', '#2d2d2d', '#e85d04', '#6c757d', '#f8f9fa'];
            
            if (in_array($newColor, $allowedColors)) {
                $_SESSION['bg_color'] = $newColor;
            }
            
            $this->redirect('index', 'main');
            return;
        }

        $currentColor = $_SESSION['bg_color'] ?? '#f8f9fa';

        $this->render('index/main', [
            'currentColor' => $currentColor,
            'welcomeMessage' => isset($_COOKIE['user_name']) ? "З поверненням, " . htmlspecialchars($_COOKIE['user_name']) . "!" : "Вітаємо у PowerGym!"
        ], 'Головна сторінка');
    }
}