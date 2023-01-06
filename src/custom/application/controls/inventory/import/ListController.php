<?php

class ListController extends BackendAuthController
{
  public function index()
  {    
    $conditions = new stdClass();
    if(isset($_GET['date'])) {
      $conditions->date = $_GET['date'];
    } else {
      $conditions->date = Date::getYesterdayDate();
    }
    
    $imports = Pagination::build(array(
        "data" => array("InventoryImport", "getByConditions"),
        "count" => array("InventoryImport", "getCountByConditions"),
        "length" => 30,
        "param" => array($conditions)
    ));
    
    $this->view->date = $conditions->date;
    $this->view->imports = $imports;
    $this->view->panel = "admin";
    $this->view->menu = "inventory_import_list";
    $this->view->show("/inventory/import/list");
  }
}
