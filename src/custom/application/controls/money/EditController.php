<?php

class EditController extends BackendAuthController
{
  public function index($money_id)
  {
    $money_record = Money::getById($money_id);
    if(!$money_record) { show404(); }
    
    $errors = new \GUI\ErrorMessage();
    
    if($this->is_method_post()) {
      $data = new stdClass();
      $data->money_id = $money_id;
      $data->date = $_POST['date'];
      $data->type = $_POST['type'];
      $data->amount_income = $_POST['amount_income'];
      $data->amount_expense = $_POST['amount_expense'];
      $data->note = $_POST['note'];
      
      $errors = $this->__validate($data);
      
      if(!$errors->hasError()) {
        if(Money::edit($data)) {
          \GUI\SuccessMessage::add("Money record edited successfully.");
          $this->redirect();
        } else {
          $errors->add("Something went wrong.");
        }
      }
    }
    
    $this->view->money_record = $money_record;
    $this->view->errors = $errors;
    $this->view->panel = "admin";
    $this->view->menu = "money";
    $this->view->show("/money/edit");
  }
  
  private function __validate($data)
  {
    $errors = new \GUI\ErrorMessage();
    
    $money_record =  Money::getByDateAndType($data->date, $data->type);
    if($money_record && $data->money_id != $money_record->money_id) {
      $errors->add("Money record on this date <a href='/money/edit/{$money_record->money_id}'>{$money_record->money_date}</a> is already added into system.");
    }
    
    return $errors;
  }
}
