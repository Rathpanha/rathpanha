<?php

namespace GUI;

class ErrorMessage 
{
    public function __construct()
    {
        $this->messages = array();
    }
    
    public function clear()
    {
        $this->messages = array();
    }
    
    public function add($message) 
    {
        $this->messages[] = $message;
    }
    
    public function  addObject(ErrorMessage $errors)
    {
        foreach ($errors->messages as  $message) {
            $this->messages[]=$message;
        }
    }
    
    public function hasError() 
    {
        return count($this->messages) > 0;
    }
    
    public function showError()
    {
        //var_dump($this->messages);
        if (count($this->messages) > 0) {
          echo "<div class='_error'>";
            echo "<div class='_title'><i class='fas fa-times-circle fa-sm'></i> Error</div>";
            echo "<ul style='margin: 0px; padding: 10px 25px;'>";
              foreach ($this->messages as $msg) {
                $message = lang($msg, true);
                
                echo "<li><label class='m0'>{$message}</label></li>";
              }
            echo "</ul>";
          echo "</div>";
          echo "<br>";
        }
    }
    
  public static function addGlobal($message) 
  {
    $_SESSION['ERROR_MESSAGE'] = $message;
  }

  public static function showErrorGlobal() 
  {
    if (isset($_SESSION['ERROR_MESSAGE'])) {
      $message = lang($_SESSION['ERROR_MESSAGE'], true);
      
      echo "<div class='_error' style='width: 100%;'>";
        echo "<div class='_title'><i class='fas fa-check-circle fa-sm'></i> Error</div>";
        echo "<ul style='margin: 0px; padding: 10px 25px;'>";
          echo "<li><label class='m0'>{$message}</label></li>";
        echo "</ul>";
      echo "</div>";
    }

    //Clear session
    unset($_SESSION['ERROR_MESSAGE']);
    unset($GLOBALS[_SESSION]['ERROR_MESSAGE']);
  }
}