<?php

class AddController extends BackendAuthController
{
  public function index()
  {
    $errors = new \GUI\ErrorMessage();
    
    if($this->is_method_post()) {
      $data = new stdClass();
      $data->name = trim($_POST['name']);
      $data->added_by = $this->user->account_id;
      
      $errors = $this->__validate($data);
      
      if(!$errors->hasError()) {
        if(Merchant::add($data)) {
          \GUI\SuccessMessage::add("Merchant {$data->name} added successfully.");
          $this->redirect();
        } else {
          $errors->add("Something went wrong.");
        }
      }
    }
    
    
    $this->view->errors = $errors;
    $this->view->panel = "admin";
    $this->view->menu = "merchant_add";
    $this->view->show("/merchant/add");
  }
  
  private function __validate($data)
  {
    $errors = new \GUI\ErrorMessage();
    
    $merchant = Merchant::getByName($data->name);
    if($merchant) {
      $errors->add("Merchant's name is duplicate with <a href='/merchant/edit/{$merchant->merchant_id}'>merchant(#{$merchant->merchant_id})</a>.");
    }
    
    return $errors;
  }
}
