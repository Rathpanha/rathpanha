<?php

class RandomString
{
    /**
    * Make random code
    *
    * @param number $length           
    * @return string
    */
    public static function rnd_code($length = 8, $characters_random = null) {
        $characters = '12345679ACDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        if(!is_null($characters_random)) {
            $characters = $characters_random;
        }
        
        $randomString = '';
        for($i = 0; $i < $length; $i ++) {
            $randomString .= $characters [rand ( 0, strlen ( $characters ) - 1 )];
        }
        
        return $randomString;
    }
}
