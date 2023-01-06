<?php

class Controller
{
    protected $view;
    protected $config;
    
    public function __construct()
    {
        $this->config = Application::$Configuration;
        $this->view = new View();
    }
    
    public function is_method_post()
    {
            return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    public function redirect($url = "")
    {
        if($url === "") {
            header("LOCATION: {$_SERVER['REQUEST_URI']}");
        } else if (strpos($url, 'http://') === 0) {
            header("LOCATION: {$url}");
        } else if (strpos($url, 'https://') === 0) {
            header("LOCATION: {$url}");
        } else {
            header("LOCATION: /" . ltrim($url, '/'));
        }
        
        exit();
    }
}