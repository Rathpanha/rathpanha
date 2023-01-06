<?php

class AuthController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    \Security\CSRF::init();
    \Security\CSRF::log();
    \Security\CSRF::guard();
    
    // $user = new AdminAuthentication();
    // $user->check();    
    // $this->view->user = $user;
    // $this->user = $user;

    // Create dummy header
    $this->header = new StdClass();
    $this->header->title = "Rathpanha";
    $this->header->description = "Hello! My name's Sarun Rathpanha. I'm full stack developer at GroupIn.";
    $this->view->header = $this->header;
  }
}
