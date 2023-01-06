<?php

class Merchant 
{
  public static function add($data)
  {
    $db = DB::getConnection();
    
    return $db->query("INSERT INTO merchant(merchant_name, merchant_added_by, merchant_added_datetime)
                       VALUES(:merchant_name, :merchant_added_by, :merchant_added_datetime)",
                      [
                        "merchant_name" => $data->name,
                        "merchant_added_by" => $data->added_by,
                        "merchant_added_datetime" => Date::getNowDateTime()
                      ]);
  }
  
  public static function edit($data)
  {
    $db = DB::getConnection();
    
    return $db->query("UPDATE merchant SET merchant_name = :merchant_name 
                       WHERE merchant_id = :merchant_id", 
                       [
                        "merchant_name" => $data->name,
                        "merchant_id" => $data->merchant_id
                       ]);
  }
  
  public static function getAll($order = "ORDER BY merchant_id")
  {
    $db = DB::getConnection();
    
    return $db->select("SELECT * FROM merchant {$order}");
  }
  
  public static function getById($merhcant_id)
  {
    $db = DB::getConnection();
    
    return $db->first("SELECT * FROM merchant WHERE merchant_id = :merchant_id", ["merchant_id" => $merhcant_id]);
  }
  
  public static function getByName($merhcant_name) 
  {
    $db = DB::getConnection();
    
    return $db->first("SELECT * FROM merchant WHERE merchant_name = :merchant_name", ["merchant_name" => $merhcant_name]);
  }
  
  public static function getByConditions($data, $start = null, $length = null)
  {
    $db = DB::getConnection();
    list($conditions, $params) = self::__getConditions($data);
    
    $limit = "";
    if(!is_null($start) || !is_null($length)) {
      $limit = "LIMIT :start, :length";
      $params["start"] = array($start, PDO::PARAM_INT);
      $params["length"] = array($length, PDO::PARAM_INT);
    }
    
    return $db->select("SELECT * FROM merchant
                       {$conditions}
                       ORDER BY merchant_id
                       {$limit}", $params);
  }
  
  public static function getCountByConditions($data)
  {
    $db = DB::getConnection();
    list($conditions, $params) = self::__getConditions($data);
   
    return $db->first("SELECT COUNT(*) AS t FROM merchant
                      {$conditions}", $params)->t;
  }
  
  private static function __getConditions($data)
  {
    $conditions = "WHERE true";
    $params = array();

    //var_dump($data, $conditions, $params); exit();
    return array($conditions, $params);
  }
}
