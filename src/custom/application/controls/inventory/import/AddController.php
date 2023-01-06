<?php

class AddController extends BackendAuthController
{
  public function index()
  {
    $errors = new \GUI\ErrorMessage();
    
    if($this->is_method_post()) {
      $data = new stdClass();
      $data->datetime = $_POST['datetime'];
      $data->merchant_id = $_POST['merchant_id'];
      $data->cart_big = $_POST['cart_big'];
      $data->cart_small = $_POST['cart_small'];
      $data->inventories = $_POST['inventories'];
      $data->added_by = $this->user->account_id;
      
      $last_id = InventoryImport::add($data);
      if($last_id) {
        \GUI\SuccessMessage::add("Inventory imported successfully.");
        $this->redirect("/inventory/import/edit/{$last_id}");
      } else {
        $errors->add("Something went wrong.");
      }
    }
    
    $this->view->inventories = Inventory::getAll();
    $this->view->merchants = Merchant::getAll();
    $this->view->errors = $errors;
    $this->view->panel = "admin";
    $this->view->menu = "inventory_import_add";
    $this->view->show("/inventory/import/add");
  }
}
