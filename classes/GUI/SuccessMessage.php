<?php

namespace GUI;

class SuccessMessage 
{
  public static function add($message) 
  {
    $_SESSION['SUCCESS_MESSAGE'] = $message;
  }

  public static function showSuccess() 
  {
    if (isset($_SESSION['SUCCESS_MESSAGE'])) {
      $message = lang($_SESSION['SUCCESS_MESSAGE'], true);
      
      echo "<div class='_success' style='width: 100%;'>";
        echo "<div class='_title'><i class='fas fa-check-circle fa-sm'></i> Success</div>";
        echo "<ul style='margin: 0px; padding: 10px 25px;'>";
          echo "<li><label class='m0'>{$message}</label></li>";
        echo "</ul>";
      echo "</div>";
    }

    //Clear session
    unset($_SESSION['SUCCESS_MESSAGE']);
    unset($GLOBALS[_SESSION]['SUCCESS_MESSAGE']);
  }
}
