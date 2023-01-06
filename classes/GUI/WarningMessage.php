<?php

namespace GUI;

class WarningMessage 
{
  public static function add($message) 
  {
    $_SESSION['WARNING_MESSAGE'] = $message;
  }

  public static function showWarning() 
  {
    if (isset($_SESSION['WARNING_MESSAGE'])) {
      $message = lang($_SESSION['WARNING_MESSAGE'], true);
      
      echo "<div class='_warning' style='width: 100%;'>";
        echo "<div class='_title'><i class='fas fa-exclamation-circle fa-sm'></i> Warning</div>";
        echo "<ul style='margin: 0px; padding: 10px 25px;'>";
          echo "<li><label class='m0'>{$message}</label></li>";
        echo "</ul>";
      echo "</div>";
    }

    //Clear session
    unset($_SESSION['WARNING_MESSAGE']);
    unset($GLOBALS[_SESSION]['WARNING_MESSAGE']);
  }
}
