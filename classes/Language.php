<?php


class Language 
{
    protected static $kh_dict = array(
     
    );
    
    protected static $jp_dict = array(
       
    );
    
    private static $language = null;
    
    /**
     * Use to set language to private language variable
     * 
     * @param type $string accepted value "en", "kh", "jp"
     * 
     * @return nothing
     */ 
    public static function setLanguage($language)
    {
        self::$language = $language;
    }
    
    /**
     * Use to get language
     * @return  type $string, return "en", "kh", "jp" default "en" 
     */ 
    public static function getLanguage()
    {
        if(isset($_COOKIE['lang'])) {
            $cookie_lang = $_COOKIE['lang'];
            
            if($cookie_lang != "en" && $cookie_lang != "kh" && $cookie_lang != "jp")
                return "en";
            return $cookie_lang;
        } else {
            $lang = self::$language;
            
            if($lang != "en" && $lang != "kh" && $lang != "jp")
                return "en";
            return $lang;
        }
    }
    
    /**
     * Use to get the translation of phrase or word
     * 
     * @param type $string
     * @return $string return translated phrase or word, if don't have return English
     */ 
    public static function get($phrase) {
        $lang = self::getLanguage();
        $lower_phrase = strtolower($phrase);

        switch($lang){
            case "en" : 
                    return $phrase;
                break;
            
            case "kh" : 
                    if(isset(self::$kh_dict[$lower_phrase])) {
                        return self::$kh_dict[$lower_phrase];
                    }
                break;
            
            case "jp" :
                    if(isset(self::$jp_dict[$lower_phrase])) {
                        return self::$jp_dict[$lower_phrase];
                    }
                break;
        }
        
        return $phrase;
    }
    
    /**
     * Use to get translate base on $language
     * 
     * @param type $en_phrase
     * @param type $kh_phrase
     * @param type $jp_phrase
     * 
     * @return $string translated.
     */ 
    public static function getTranslate($json)
    {
        $lang = self::getLanguage();
        $json_decoded = json_decode($json);

        switch($lang){
            case "en" : 
                    if($json_decoded->en != "")
                        return $json_decoded->en;
                break;
            
            case "kh" :
                    if($json_decoded->kh != "")
                        return $json_decoded->kh;
                break;
            
            case "jp" :
                    if($json_decoded->jp != "")
                        return $json_decoded->jp;
                break;
        }
        
        return $json_decoded->en;
    }
}
