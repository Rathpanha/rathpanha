<?php

class PhoneNumber 
{
    const SMART_CARRIER = 1;
    const MOBITEL_CARRIER = 2;
    const METFONE_CARRIER = 3;
    const OTHER_CARRIER = 4;
    
    public static function getMobileCarrier($phone)
    {
        $carriers = array(
            self::MOBITEL_CARRIER => array('12', '17', '77', '78', '89', '92', '95', '11', '61', '76', '85', '99'),
            self::SMART_CARRIER => array('10', '69', '70', '86', '93', '96', '98', '15', '16', '81', '87'),
            self::METFONE_CARRIER => array('97', '88', '71')
        );

        $ext = substr(self::trim($phone), 0, 2);
        
        foreach($carriers as $carrier => $ext_list) {
            if (in_array($ext, $ext_list)) { return $carrier; }
        }
        
        return self::OTHER_CARRIER;
    }
    
    public static function getSaleNumber($carrier)
    {
        $carriers = array(
            self::MOBITEL_CARRIER => array("092552262", "016955505", "016955505"),
            self::SMART_CARRIER => array("016955505 ", "092552262", "016955505"),
            self::METFONE_CARRIER => array("0976239423", "016955505 ","016955505"),
            self::OTHER_CARRIER => array("016955505","016955505","016955505")
        );
        $tmp = $carriers[$carrier];
        return $tmp;
    }
    
    public static function trim($phone)
    {
        $phone = trim($phone);
            if (strlen($phone) > 8) {				// prevent trimming 085 5....
		if (substr($phone, 0, 4) == "+855") {
                    $phone = substr($phone, 4);		// +TRIM 855
		} else if (substr($phone, 0, 3) == "855") {
                    $phone = substr($phone, 3);     // +TRIM 855
                } else if(substr($phone, 0, 6) == "(+855)") {
                    $phone = substr($phone, 6);
                }
            }

            $phone = ltrim($phone, "0");			// TRIM 0
            $phone = str_replace(" ", "", $phone);
		
            return $phone;
    }
    
    public static function validate($phone)
    {
        return preg_match("/^\d{8,12}$/", $phone) === 1;
    }
    
    public static function getFullFormat($phone)
    {
        $phone = self::trim($phone);
        return "0" . $phone;
    }
}
