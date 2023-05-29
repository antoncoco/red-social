<?php
namespace Cocol\Redsocial\lib;
use Cocol\Redsocial\lib\View;

class Controller
{
    private View $view;
    public function __construct()
    {
        $this->view = new View();
    }

    public function render(String $name, array $data = []) {
        $this->view->render($name, $data);
    }

    protected function post(String $param)
    {
        if (!isset($_POST[$param])) {
            return NULL;
        }
        return $_POST[$param];
    }

    protected function get(String $param)
    {
        if (!isset($_GET[$param])) {
            return NULL;
        }
        return $_GET[$param];
    }

    protected function file(String $param)
    {
        if (!isset($_FILES[$param])) {
            return NULL;
        }
        return $_FILES[$param];
    }
}
