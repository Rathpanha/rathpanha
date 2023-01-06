<?php

class ListController extends BackendAuthController
{
  public function index()
  {
    if(isset($_GET['inventory_id']) && is_numeric($_GET['inventory_id'])) {
      $this->redirect("/inventory/edit/" . $_GET['inventory_id']);
    }
    
    $conditions = new stdClass();
    $inventories = Pagination::build(array(
        "data" => array("Inventory", "getByConditions"),
        "count" => array("Inventory", "getCountByConditions"),
        "length" => 20,
        "param" => array($conditions)
    ));
    
    $this->view->inventories_all = Inventory::getAll();
    $this->view->inventories = $inventories;
    $this->view->panel = "admin";
    $this->view->menu = "inventory_list";
    $this->view->show("/inventory/list");
  }
}
