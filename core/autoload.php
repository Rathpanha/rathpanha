<?php

spl_autoload_register(function($class) 
{
    foreach(Application::$Configuration->classes as $path) {
		$file = $path . str_replace('\\', '/', $class) . '.php';
		
        if (file_exists($file)) {
            include_once($file);
            break;
        }
    }
});