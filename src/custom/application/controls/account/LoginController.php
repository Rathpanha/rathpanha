<?php

class LoginController extends AuthController
{
  public function index() 
  {
    if($this->user->isLogin()) {
      $this->redirect("/");
    }
    
    $errors = new \GUI\ErrorMessage();
    
    if($this->is_method_post()) {
      $data = new stdClass();
      $data->username = $_POST['username'];
      $data->password = $_POST['password'];
      $data->stay_login = isset($_POST['stay_login']);
      
      if($this->user->attempt($data->username, $data->password, $data->stay_login)) {
        $this->redirect("/");
      } else {
        $errors->add("Incorrect username or password.");
      }
    }
    
    $this->view->errors = $errors;
    $this->view->show("/account/login");
  }
}
