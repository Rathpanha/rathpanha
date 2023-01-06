<?php

class Route
{
    protected static $default;
    protected static $custom = array();
    
    /**
     * 
     * @param type $controller
     */
    public static function setDefaultController($controller)
    {
        Route::$default = $controller;
    }
    
    /**
     * 
     * @param array $route
     */
    public static function setCustomRoute(array $route)
    {
        Route::$custom = $route;
    }
    
    /**
     * 
     */
    public static function Run()
    {
        // Get the current path
        if (isset($_SERVER['PATH_INFO']) && is_string($_SERVER['PATH_INFO'])) {
            $path = trim($_SERVER['PATH_INFO'], '/');
        } else {
            $path = "";
        }
        
        // If the path is empty, use default controller
        if (empty($path)) {
            $status = Route::getControllerByNativeDirectory(Route::$default);
        } else {
            $status = Route::getControllerByNativeDirectory($path);
        }
        
        if (!$status) {
            show404();
        }
    }
    
    /**
     * 
     * @param string $path Path to the controller
     * @return mixed Return the array of controller detail information
     *               (controller_name, action, param) or else
     *               return FALSE.
     */
    public static function getControllerByNativeDirectory($path)
    {
        $directoryDepth = 0;
        $directoryAccumulate = Application::$ApplicationPath . '/application/controls/';
        $directory = explode('/', $path);

        // drilling the directory as deep as possible
        while( (count($directory) > $directoryDepth) && 
               is_dir($directoryAccumulate . $directory[$directoryDepth])) 
        {
            $directoryAccumulate .= $directory[$directoryDepth] . '/';
            $directoryDepth++;
        }

        // if we drill all directory, and no controller is found
        if ($directoryDepth >= count($directory)) {
            return false;
        }

        // check if there is controller we want
        $controller = $directory[$directoryDepth] . 'Controller';
        $controllerPath = $directoryAccumulate . ucfirst($controller) . '.php';
        if (file_exists($controllerPath)) {
            $controller = ucfirst($controller);
            include_once($controllerPath);
        } else {
            return false;
        }

        // check for actions
        $directoryDepth++;
        if ($directoryDepth >= count($directory)) {
            $action = 'index';
        } else {
            $action = strtolower($directory[$directoryDepth]);
            if (!is_callable(array($controller, $action)) || (substr($action, 0, 2) === '__')) {
                $action = 'index';
                $directoryDepth--;
            }
        }

        // check if there is any arguments
        $arg = array_slice($directory, $directoryDepth + 1);

        // creating the controller
        $obj = new $controller();

        // processing our web application
        call_user_func_array(array($obj, $action), $arg);

        return $obj;
    }
}