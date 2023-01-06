<?php

namespace Security;

/**
 * Defensing mechanism for Cross-Site Request Forgery (CSRF)
 * To guard against CSRF, you need to put below code in the 
 * beginning of your controller.
 *
 *    \Security\CSRF::init()
 *    \Security\CSRF::guard()
 *
 * And put \Security\CSRF::generateField() in every form.
 *
 * Reference:
 *   - https://www.owasp.org/index.php/Cross-Site_Request_Forgery_(CSRF)_Prevention_Cheat_Sheet
 *   - https://medium.com/@barryvdh/csrf-protection-in-laravel-explained-146d89ff1357
 */
class CSRF 
{
    protected static $token = false;
    const TOKEN_NAME = 'XSRF-TOKEN';
    
    /**
     * Initialize the CSRF defence feature. It should be used
     * with \Security\CSRF::guard()
     */
    public static function init()
    {
        // Generate the CSRF token if have not been generated
        if ( !isset($_COOKIE[self::TOKEN_NAME]) ) {
            $token = bin2hex(openssl_random_pseudo_bytes(32));
            setcookie(self::TOKEN_NAME, $token, 0, "/");
            self::$token = $token;
        } else {
            self::$token = $_COOKIE[self::TOKEN_NAME];
        }
    }

    protected static function checkMatchedToken()
    {
        // We do not safe guard against HEAD, GET, and OPTIONS method
        if ( in_array( strtoupper($_SERVER['REQUEST_METHOD']), ["HEAD", "GET", "OPTIONS"] ) ) {
            return true;
        }

        $requestedToken = "";
        if (isset( $_POST['_token'] )) {
            $requestedToken = $_POST['_token'];
        } else if ( isset( $_SERVER['HTTP_X_CSRF_TOKEN'] ) ) {
            $requestedToken = $_SERVER['HTTP_X_CSRF_TOKEN'];
        }
        
        // We check if token is matched
        if ( self::getToken() !== false ) {
            if ( self::getToken() == $requestedToken) {
                return true;
            }
        }

        return false;
    }

    /**
     * Log when user attempt to attack
     */
    public static function log()
    {
        if (self::checkMatchedToken()) return true;
        
        $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $country = $_SERVER["HTTP_CF_IPCOUNTRY"];
        $method = $_SERVER['REQUEST_METHOD'];

        $msg  = \Date::getNowDateTime() . " : ";
        $msg .= "[{$method}] ";
        $msg .= $_SERVER['REQUEST_URI'] . " - ";
        $msg .= "({$ip}) {$country}";

        Log::write($msg, "csrf");
    }
    
    /**
     * Activate the guarding function against the CSRF attack
     * using Double Submit Cookie technique
     */
    public static function guard()
    {
        if (self::checkMatchedToken()) return true;
        
        // Token does not match, activate the prevention
        echo "CSRF Prevention Activated";
        exit();
    }
    
    /**
     * Get the token that is used for safe-guard the CSRF
     */
    public static function getToken()
    {
        return self::$token;
    }
    
    /**
     * Generate a HTML meta code
     */
    public static function generateMeta()
    {
        echo '<meta name="csrf-token"  content="' . self::getToken() . '" />';
    }
    
    /**
     * Generate a hidden input token that will be used to verify
     * with the token in the cookie
     */
    public static function generateField()
    {
        echo "<input type='hidden' name='_token' value='" . self::getToken() . "'/>";
    }
}
