<?php

class LogoutController extends AuthController 
{
  public function index() 
  {
    $this->user->logout();
    $this->redirect("/account/login");
  }
}
