<?php

class HomeController extends BackendAuthController 
{
  public function index() 
  {
    $this->view->panel = "admin";
    $this->view->menu = "dashboard";
    $this->view->show("home");
  }
}
