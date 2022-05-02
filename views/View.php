<?php
class View
{
    private function verifyViewExist(string $viewPath)
    {
        if(file_exists($viewPath)) {
            return true;
        } else {
            return false;
        }
    }
    private function callView(string $viewPath)
    {
        if($this->verifyViewExist($viewPath)) {
            return true;
        } else {
            die("<h1 class='error'>View path is wrong</h1>");
        }
    }
    public function getView($viewPath,?array $data = [])
    {
        $viewPath = $_SERVER['DOCUMENT_ROOT'] . "/views/" . ucfirst($viewPath) . "View.php";
        if($this->callView($viewPath)) {
            require_once($viewPath);
        } 
    }
}