<?php

class SecurityController extends BackendAuthController
{
  public function index() 
  {
    $errors = new \GUI\ErrorMessage();

    if ($this->is_method_post()) {
      $data = new stdClass();
      $data->account_id = $this->user->account_id;
      $data->password_current = $_POST['password_current'];
      $data->password_new = $_POST['password_new'];
      $data->password_new_confirm = $_POST['password_new_confirm'];
      $errors = $this->__validate($data);

      if (!$errors->hasError()) {
        User::editPassword($data);
        \GUI\SuccessMessage::add("Your password is updated successfully!");
        $this->redirect();
      }
    }

    $this->view->errors = $errors;
    $this->view->panel = "admin";
    $this->view->menu = "account_setting";
    $this->view->toolbar = "security";
    $this->view->show("/account/security");
  }

  private function __validate($data) 
  {
    $errors = new \GUI\ErrorMessage();
    if (!password_verify($data->password_current, $this->user->account_password)) {
      $errors->add("Current password is incorrect.");
    }

    if (strlen($data->password_new) < 8 || strlen($data->password_new_confirm) < 8) {
      $errors->add("Password must be 8 characters up.");
    }

    if ($data->password_new !== $data->password_new_confirm) {
      $errors->add("New passwords does not match.");
    }

    if (password_verify($data->password_new, $this->user->account_password)) {
      $errors->add("Current password and New password can not be the same.");
    }

    return $errors;
  }
}
