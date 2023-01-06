<?php
class BackendAuthController extends AuthController 
{
  public function __construct() 
  {
    parent::__construct();

    // if(!$this->user->isLogin()){
      // if($_SERVER['REQUEST_URI'] != "/") {
        // $this->redirect("/account/login?redirect=" . $_SERVER['REQUEST_URI']);
      // } else {
        // $this->redirect("/account/login");
      // }
    // }
  }
}
