<?php
class View 
{
    public function render(string $viewFile, array $data = [], string $title = ''): void 
    {
        extract($data);
        
        $fullPath = __DIR__ . '/../views/' . $viewFile . '.php';
        if (file_exists($fullPath)) {
            require $fullPath;
        } else {
            trigger_error("Представлення {$viewFile} не знайдено", E_USER_WARNING);
        }
    }
}