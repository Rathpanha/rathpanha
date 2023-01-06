<?php

include_once(__DIR__ . '/autoload.php');
include_once(__DIR__ . '/functions.php');
include_once(__DIR__ . '/route.php');
include_once(__DIR__ . '/database.php');
include_once(__DIR__ . '/controller.php');
include_once(__DIR__ . '/view.php');

/**
 * 
 */
class Environment
{
    public static $Production = 0;
    public static $Development = 1;
    public static $Testing = 2;
}

/**
 * 
 */
class Application
{
    public static $Environment;
    public static $ApplicationPath;
    public static $Configuration;

    /**
     * Parsing the configuration and loading the core functionality
     * of the application. Then, execute the application.
     */
    public static function Run() 
    {
		/*
         * Loading the global configuration file
         */
		$global_config = require_once(Application::$ApplicationPath . '/../../config.php');
		
        /*
         * Loading the sub configuration file
         */
		Application::$Configuration = require_once(Application::$ApplicationPath . '/application/config.php');
  
        Application::$Configuration = (object) array_merge((array)Application::$Configuration, (array)$global_config);
		
		date_default_timezone_set(Application::$Configuration->timezone);
        
        /*
         * Loading the route setting
         */
        include_once(Application::$ApplicationPath . '/application/routes.php');
        Route::Run();
    }
}