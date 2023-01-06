<?php

class HomeController extends AuthController 
{
  public function index() 
  {
    $this->view->show("home");
  }
}
