<?php

class Date
{
  /**
   * Get the current date
   * 
   * @return string The current date
   */
  public static function getNowDate() 
  {
    if (Application::$Environment == Environment::$Development) {
      return date('Y-m-d');
    } else {
      return date('Y-m-d');
    }
  }

  public static function getByFormat($format) 
  {
    return date($format, strtotime(self::getNowDateTime()));
  }

  /**
   * Get the current date and time
   * 
   * @return string The current date and time
   */
  public static function getNowDateTime() 
  {
    if (Application::$Environment == Environment::$Development) {
      //return date('Y-m-d H:i:s');
      //return '2016-07-18 08:46:34';
      return date('Y-m-d H:i:s');
    } else {
      return date('Y-m-d H:i:s');
    }
  }

  public static function getNowTimestamp() 
  {
    return strtotime(self::getNowDateTime());
  }

  /**
   * Get the yesterday date
   * 
   * @return string Yesterday date
   */
  public static function getYesterdayDate() 
  {
    return date("Y-m-d", strtotime(self::getNowDate() . " -1 day"));
  }
  
  /**
   * Get the yesterday date time
   * 
   * @return string Yesterday date time
   */
  public static function getYesterdayDateTime() 
  {
    return date("Y-m-d H:i:s", strtotime(self::getNowDateTime() . " -1 day"));
  } 

  
  /**
   * Get the tomorrow date
   * 
   * @return string Tomorrow date
   */
  public static function getTomorrowDate() 
  {
    return date("Y-m-d", strtotime(self::getNowDateTime() . " +1 day"));
  }
  
  /**
   * Get the tomorrow date time
   * 
   * @return string Tomorrow date time
   */
  public static function getTomorrowDateTime() 
  {
    return date("Y-m-d H:i:s", strtotime(self::getNowDateTime() . " +1 day"));
  }

  /**
   * Get next week date
   * 
   * @return string Next week date
   */
  public static function getNextWeekDate()
  {
    return date("Y-m-d", strtotime(self::getNowDate() . " +7 day"));
  }

  /**
   * Get last week date
   * 
   * @return string Last week date
   */
  public static function getLastWeekDate()
  {
    return date("Y-m-d", strtotime(self::getNowDate() . " -7 day"));
  }

  /**
   * Get next month date
   * 
   * @return string Next month date
   */
  public static function getNextMonthDate()
  {
    return date("Y-m-d", strtotime(self::getNowDate() . " +1 month"));
  }

  /**
   * Get last month date
   * 
   * @return string Last month date
   */
  public static function getLastMonthDate()
  {
    return date("Y-m-d", strtotime(self::getNowDate() . " -1 month"));
  }

  public static function convertToISO($date)
  {
    $d = new DateTime($date);
    return $d->format(DateTime::RFC822);
  }
  
  public static function convertToReadable($date, $show_hour = false)
  {
    $d = new DateTime($date);
    
    if(!$show_hour) {
      return $d->format("D, d M Y");
    } else {
      return $d->format("D, d M Y - H:i");
    }
  }

  public static function calculateElapseTime($time) 
  {
    $time = time() - strtotime($time); // to get the time since that moment
    $time = ($time < 1) ? 1 : $time;
    $tokens = array(
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) 
    {
      if ($time < $unit)
        continue;
      $numberOfUnits = floor($time / $unit);
      return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1 ) ? 's' : '');
    }
  }

  public static function calculateKhmerElapseTime($time) 
  {
    $time = time() - strtotime($time); // to get the time since that moment
    $time = ($time < 1) ? 1 : $time;
    $tokens = array(
        31536000 => 'ឆ្នាំ',
        2592000 => 'ខែ',
        604800 => 'សប្តាហ៍',
        86400 => 'ថ្ងៃ',
        3600 => 'ម៉ោង',
        60 => 'នាទី',
        1 => 'វិនាទី'
    );

    foreach ($tokens as $unit => $text) {
      if ($time < $unit)
        continue;
      $numberOfUnits = floor($time / $unit);
      return $numberOfUnits . ' ' . $text;
    }
  }
}
