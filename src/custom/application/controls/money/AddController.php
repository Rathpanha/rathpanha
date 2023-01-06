<?php

class AddController extends BackendAuthController
{
  public function index()
  {
    $errors = new \GUI\ErrorMessage();
    
    if($this->is_method_post()) {
      $data = new stdClass();
      $data->added_by = $this->user->account_id;
      $data->date = $_POST['date'];
      $data->type = $_POST['type'];
      $data->amount_income = $_POST['amount_income'];
      $data->amount_expense = $_POST['amount_expense'];
      $data->note = $_POST['note'];
      
      $errors = $this->__validate($data);
      
      if(!$errors->hasError()) {
        if(Money::add($data)) {
          \GUI\SuccessMessage::add("Money record added successfully.");
          $this->redirect();
        } else {
          $errors->add("Something went wrong.");
        }
      }
    }
    
    
    $this->view->errors = $errors;
    $this->view->panel = "admin";
    $this->view->menu = "money_add";
    $this->view->show("/money/add");
  }
  
  private function __validate($data)
  {
    $errors = new \GUI\ErrorMessage();
    
    $money_record = Money::getByDateAndType($data->date, $data->type);
    if($money_record) {
      $errors->add("Money record on this date <a href='/money/edit/{$money_record->money_id}'>{$money_record->money_date}</a> is already added into system.");
    }
    
    return $errors;
  }
}
