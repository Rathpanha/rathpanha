<?php

class PrintController extends BackendAuthController
{
  public function index()
  {
    $conditions = new stdClass();
    $conditions->type = $_GET['type'];
    if(isset($_GET['start_date'])) {
      $conditions->start_date = $_GET['start_date'];
    } else {
      $conditions->start_date = date("Y-m-01", Date::getNowTimestamp());
    }
    
    if(isset($_GET['end_date'])) {
      $conditions->end_date = $_GET['end_date'];
    } else {
      $conditions->end_date = date("Y-m-t", Date::getNowTimestamp());
    }
    
    $money_records = Pagination::build(array(
        "data" => array("Money", "getByConditions"),
        "count" => array("Money", "getCountByConditions"),
        "length" => 31,
        "param" => array($conditions)
    ));
    
    $this->view->type = $conditions->type;
    $this->view->start_date = $conditions->start_date;
    $this->view->end_date = $conditions->end_date;
    $this->view->money_records = $money_records;
    $this->view->show("/money/print");
  }
}
