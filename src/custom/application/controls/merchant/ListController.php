<?php

class ListController extends BackendAuthController
{
  public function index()
  {
    if(isset($_GET['merchant_id']) && is_numeric($_GET['merchant_id'])) {
      $this->redirect("/merchant/edit/" . $_GET['merchant_id']);
    }
    
    $conditions = new stdClass();
    $merchants = Pagination::build(array(
        "data" => array("Merchant", "getByConditions"),
        "count" => array("Merchant", "getCountByConditions"),
        "length" => 20,
        "param" => array($conditions)
    ));
    
    $this->view->merchants_all = Merchant::getAll();
    $this->view->merchants = $merchants;
    $this->view->panel = "admin";
    $this->view->menu = "merchant_list";
    $this->view->show("/merchant/list");
  }
}
