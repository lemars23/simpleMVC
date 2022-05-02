<?php
class Controller 
{
    protected $params;
    protected $model;
    protected $view;

    private $modelPath;

    public function __construct(array $params, string $modelName)
    {
        $this->params = $params;
        $this->model = $modelName . 'Model';
        $this->modelPath = $_SERVER['DOCUMENT_ROOT'] . "/models/" . $this->model . ".php";
        $this->view = new View;
        $this->callModel();
    }

    private function verifyModelExist()
    {
        if(file_exists($this->modelPath)) {
            return true;
        } else {
            return false;
        }
    }

    private function callModel()
    {
        if($this->verifyModelExist()) {
            require_once($this->modelPath);
            $this->model = new $this->model;
        } else {
            die("Model not exist!<br/>");
        }
    }


}