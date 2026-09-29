<?php
class PageController extends Controller 
{
    public function __construct() 
    {
        parent::__construct();

        $this->view = new PageView();
    }

    public function render(string $viewFile, array $data = [], string $title = ''): void 
    {
        $this->view->render($viewFile, $data, $title);
    }
}