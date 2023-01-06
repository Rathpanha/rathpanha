<?php

class AuthController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    \Security\CSRF::init();
    \Security\CSRF::log();
    \Security\CSRF::guard();

    $user = new UserAuthentication();
    $user->check();    
    $this->view->user = $user;
    $this->user = $user;

    // Create dummy header
    $this->header = new StdClass();
    $this->header->title = "Rathpanha Custom";
    $this->view->header = $this->header;
  }
}
