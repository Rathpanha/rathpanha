<?php
session_set_cookie_params(0, '/');	
session_start();



$config = new StdClass();

/*
 * Debug Mode
 * ---------------------------------------------------------
 * If application has debug mode on, it will show detail
 * error message if any error occurs. Otherwise, it only
 * show a generic error message.
 */
$config->debug = true;
    
/*
 * URL
 * ---------------------------------------------------------
 *    Specified the URL of your application. It will be used
 *    by some of our function to generate a full URL.
 */
$config->domain = env('APP_DOMAIN');
     
/*
 * Timezone
 * ---------------------------------------------------------
 *    Specified your default timezone which will be used
 *    by PHP date and time function.
 */
$config->timezone = 'Asia/Phnom_Penh';
$config->view_awareness = true;
    
/*
 * Database Connections
 * ---------------------------------------------------------
 *      List of all database connection
 */
$config->database = array(
  'default' => env('DB_CONNECTION')
);
    
/*
 * Memcached Connections
 * ---------------------------------------------------------
 *      List of all memcached connection
 */
$config->memcache = array(
    'default' => ''
);

$config->websocket = env('WS_CONNECTION');

return $config;