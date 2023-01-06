<?php

class EditController extends BackendAuthController
{
  public function index($inventory_id)
  {
    $inventory = Inventory::getById($inventory_id);
    if(!$inventory_id) { show404(); }
    
    $errors = new \GUI\ErrorMessage();
    
    if($this->is_method_post()) {
      $data = new stdClass();
      $data->inventory_id = $inventory->inventory_id;
      $data->name = trim($_POST['name']);
      $data->added_by = $this->user->account_id;
      
      $errors = $this->__validate($data);
      
      if(!$errors->hasError()) {
        if(Inventory::edit($data)) {
          \GUI\SuccessMessage::add("Inventory edited successfully.");
          $this->redirect();
        } else {
          $errors->add("Something went wrong.");
        }
      }
    }
    
    $this->view->inventory = $inventory;
    $this->view->errors = $errors;
    $this->view->panel = "admin";
    $this->view->menu = "inventory";
    $this->view->show("/inventory/edit");
  }
  
  private function __validate($data)
  {
    $errors = new \GUI\ErrorMessage();
    
    $inventory = Inventory::getByName($data->name);
    if($inventory && $inventory->inventory_id != $data->inventory_id) {
      $errors->add("Inventory's name is duplicate with <a href='/inventory/edit/{$inventory->inventory_id}'>inventory(#{$inventory->inventory_id})</a>.");
    }
    
    return $errors;
  }
}
