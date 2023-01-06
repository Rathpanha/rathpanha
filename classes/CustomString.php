<?php

class CustomString
{
    /**
    * Make random code
    *
    * @param number $length           
    * @return string
    */
    public static function rnd_code($length = 8) {
        $characters = '2345679ACDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopq';
        $randomString = '';
        for($i = 0; $i < $length; $i ++) {
            $randomString .= $characters [rand ( 0, strlen ( $characters ) - 1 )];
        }
        
        return $randomString;
    }
}
