<?php

class PageView extends View 
{
    protected string $pageTitle = 'GymMaster';

    public function setTitle(string $title): void 
    {
        $this->pageTitle = $title;
    }

    public function render(string $viewFile, array $data = [], string $title = ''): void 
    {
        if ($title !== '') {
            $this->pageTitle = $title;
        }
        
        if (!isset($data['pageTitle'])) {
            $data['pageTitle'] = $this->pageTitle;
        }

        extract($data);

        $headerPath = __DIR__ . '/../views/layout/header.php';
        if (file_exists($headerPath)) {
            require_once $headerPath;
        } else {
            echo "<div style='color:red; padding:10px;'>Помилка: Лейаут [views/layout/header.php] не знайдено!</div>";
        }

        $fullViewPath = __DIR__ . '/../views/' . $viewFile . '.php';
        if (file_exists($fullViewPath)) {
            require $fullViewPath;
        } else {
            echo "<div style='color:red; padding:10px;'>Помилка: Шаблон представлення [views/{$viewFile}.php] не знайдено.</div>";
        }

        $footerPath = __DIR__ . '/../views/layout/footer.php';
        if (file_exists($footerPath)) {
            require_once $footerPath;
        }
    }
}