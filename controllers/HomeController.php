<?php
class HomeController extends Controller
{
    public function index()
    {
        $this->view->getView("home", $this->model->takeId());
    }

    public function sayMyName() 
    {
        $this->view->getView("saymyname");
    }
}