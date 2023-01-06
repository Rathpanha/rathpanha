<?php

class EditController extends BackendAuthController
{
  public function index($merchant_id)
  {
    $merchant = Merchant::getById($merchant_id);
    if(!$merchant) { show404(); }
    
    $errors = new \GUI\ErrorMessage();
    
    if($this->is_method_post()) {
      $data = new stdClass();
      $data->merchant_id = $merchant->merchant_id;
      $data->name = trim($_POST['name']);
      $data->added_by = $this->user->account_id;
      
      $errors = $this->__validate($data);
      
      if(!$errors->hasError()) {
        if(Merchant::edit($data)) {
          \GUI\SuccessMessage::add("Merchant edited successfully.");
          $this->redirect();
        } else {
          $errors->add("Something went wrong.");
        }
      }
    }
    
    $this->view->merchant = $merchant;
    $this->view->errors = $errors;
    $this->view->panel = "admin";
    $this->view->menu = "merchant";
    $this->view->show("/merchant/edit");
  }
  
  private function __validate($data)
  {
    $errors = new \GUI\ErrorMessage();
    
    $merchant = Merchant::getByName($data->name);
    if($merchant && $merchant->merchant_id != $data->merchant_id) {
      $errors->add("Merchant's name is duplicate with <a href='/merchant/edit/{$merchant->merchant_id}'>merchant(#{$merchant->merchant_id})</a>.");
    }
    
    return $errors;
  }
}
