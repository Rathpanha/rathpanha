<?php

function public_path()
{
  return Application::$ApplicationPath . '\public';
}

function show404($error_text = null) 
{
  header('HTTP/1.0 404 Not Found');

  $error_dir = Application::$ApplicationPath . "/application/error/";

  if (file_exists($error_dir . "404.php")) {
    include($error_dir . "404.php");
  } else {
    echo "Not found! " . $error_text;
  }

  exit();
}

/**
 * Safe Printing. Use it to print everything in the view
 * unless you really want to display HTML code directly
 * This will help prevent Cross-Site Scripting (XSS)
 *
 * @param string $str String to print
 */
function sp($str) 
{
  echo htmlspecialchars($str);
}

function lang($str, $return = false) 
{
  if($return) {
    return \Language::get($str);
  } else {
    echo \Language::get($str);
  }
}

function print_isset($var) 
{
  echo isset($var) ? $var : "";
}

function print_condition($a, $b, $print)
{
  if ($a == $b) {
    echo $print;
  }
}

function env($var, $default = null)
{
  static $env = null;
  if ($env === null) {
    $env = require_once(__DIR__ . "/../.env.php");
  }

  if (isset($env[$var]))
    return $env[$var];
  return $default;
}
