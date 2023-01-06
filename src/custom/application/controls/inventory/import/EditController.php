<?php

class EditController extends BackendAuthController
{
  public function index($import_id)
  {
    $import = InventoryImport::getById($import_id);
    if(!$import) { show404(); }
    
    $errors = new \GUI\ErrorMessage();
    
    if($this->is_method_post()) {
      $data = new stdClass();
      $data->import_id = $import->import_id;
      $data->datetime = $_POST['datetime'];
      $data->merchant_id = $_POST['merchant_id'];
      $data->cart_big = $_POST['cart_big'];
      $data->cart_small = $_POST['cart_small'];
      $data->inventories = $_POST['inventories'];
      
      if(InventoryImport::edit($data)) {
        \GUI\SuccessMessage::add("Inventory import edited successfully.");
        $this->redirect();
      } else {
        $errors->add("Something went wrong.");
      }
    }
    
    $this->view->import = $import;
    $this->view->inventories = Inventory::getAll();
    $this->view->merchants = Merchant::getAll();
    $this->view->errors = $errors;
    $this->view->panel = "admin";
    $this->view->menu = "inventory_import";
    $this->view->show("/inventory/import/edit");
  }
}
