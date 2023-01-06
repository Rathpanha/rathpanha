<?php

namespace GUI;

class InfoMessage 
{
  public static function add($message) 
  {
    $_SESSION['INFO_MESSAGE'] = $message;
  }

  public static function showInfo()
  {
    if (isset($_SESSION['INFO_MESSAGE'])) {
      $message = lang($_SESSION['INFO_MESSAGE'], true);
      
      echo "<div class='_info' style='width: 100%;'>";
        echo "<div class='_title'><i class='fas fa-info-circle fa-sm'></i> Information</div>";
        echo "<ul style='margin: 0px; padding: 10px 25px;'>";
          echo "<li><label class='m0'>{$message}</label></li>";
        echo "</ul>";
      echo "</div>";
    }

    //Clear session
    unset($_SESSION['INFO_MESSAGE']);
    unset($GLOBALS[_SESSION]['INFO_MESSAGE']);
  }
}
