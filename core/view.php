<?php

class View
{
    private function getFilePath($view, $desktop, $mobile, $mode)
    {
        $config = Application::$Configuration;
        $path = Application::$ApplicationPath;
        
        $platforms = array(
            0 =>  $path . $desktop . $view . '.php',
            1 =>  $path . $mobile . $view . '.php'
        );
        
        if ($mode != -1) {
            return (file_exists($platforms[$mode])) ? $platforms[$mode] : false;
        } else if ($config->view_awareness) {
            if ($this->isMobile() && file_exists($platforms[1])) {
                $this->currentPlatform = 1;
                return $platforms[1];
            } else {
                $this->currentPlatform = 0;
                return (file_exists($platforms[0])) ? $platforms[0] : False;
            }
        } else {
            $this->currentPlatform = 0;
            return (file_exists($platforms[0])) ? $platforms[0] : False;
        }
    }
    public function show($name, $__platform = -1)
    {
        $path = $this->getFilePath($name, '/application/views/', '/application/mobile-views/', $__platform);
        if ($path !== false) {
            extract((array)$this);
            $config = Application::$Configuration;
            
            // Show the view
            include $path;
        }
    }
    private function isMobile() 
	{	
		return 
			(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|kindle|ipod|hiptop|mini|mobi|palm|phone|pie|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]) 
            && !preg_match("/(iPad)/i", $_SERVER["HTTP_USER_AGENT"]));
		
    }
}

