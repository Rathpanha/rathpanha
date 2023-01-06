<?php

/*
 * Class Path
 * ---------------------------------------------------------
 *     Collection of path to all the classes that you will
 *     use through out the application. The priority of
 *     the class is based on the order of the path in the
 *     array.
 */
$config->classes = array(
    __DIR__ . "/../../../classes/",
    __DIR__ . "/classes/"
);
    
/*
 * URL
 * ---------------------------------------------------------
 *    Specified the URL of your application. It will be used
 *    by some of our function to generate a full URL.
 */
$config->url = env('APP_DOMAIN_PRE') . "admin." . env('APP_DOMAIN');

return $config;