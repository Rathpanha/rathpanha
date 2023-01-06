<?php
    include __DIR__ . "/../../../core/core.php";

    /*
     * Specified the path of all the application code
     */
    Application::$ApplicationPath = dirname(__DIR__);
    
    /*
     * Starting the application engine!
     */
    Application::Run();