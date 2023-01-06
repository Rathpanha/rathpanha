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
        if(Inventory::add($data)) {
          \GUI\SuccessMessage::add("Inventory {$data->name} added successfully.");
          $this->redirect();
        } else {
          $errors->add("Something went wrong.");
        }
      }
    }
    
    
    $this->view->errors = $errors;
    $this->view->panel = "admin";
    $this->view->menu = "inventory_add";
    $this->view->show("/inventory/add");
  }
  
  private function __validate($data)
  {
    $errors = new \GUI\ErrorMessage();
    
    $inventory = Inventory::getByName($data->name);
    if($inventory) {
      $errors->add("Inventory's name is duplicate with <a href='/inventory/edit/{$inventory->inventory_id}'>inventory(#{$inventory->inventory_id})</a>.");
    }
    
    return $errors;
  }
}
