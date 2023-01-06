<?php

class Inventory 
{
  public static function add($data)
  {
    $db = DB::getConnection();
    
    return $db->query("INSERT INTO inventory(inventory_name, inventory_added_by, inventory_added_datetime)
                       VALUES(:inventory_name, :inventory_added_by, :inventory_added_datetime)",
                      [
                        "inventory_name" => $data->name,
                        "inventory_added_by" => $data->added_by,
                        "inventory_added_datetime" => Date::getNowDateTime()
                      ]);
  }
  
  public static function edit($data)
  {
    $db = DB::getConnection();
    
    return $db->query("UPDATE inventory SET inventory_name = :inventory_name 
                       WHERE inventory_id = :inventory_id", 
                       [
                        "inventory_name" => $data->name,
                        "inventory_id" => $data->inventory_id
                       ]);
  }
  
  public static function getAll($order = "ORDER BY inventory_id")
  {
    $db = DB::getConnection();
    
    return $db->select("SELECT * FROM inventory {$order}");
  }
  
  public static function getById($merhcant_id)
  {
    $db = DB::getConnection();
    
    return $db->first("SELECT * FROM inventory WHERE inventory_id = :inventory_id", ["inventory_id" => $merhcant_id]);
  }
  
  public static function getByName($merhcant_name) 
  {
    $db = DB::getConnection();
    
    return $db->first("SELECT * FROM inventory WHERE inventory_name = :inventory_name", ["inventory_name" => $merhcant_name]);
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
    
    return $db->select("SELECT * FROM inventory
                       {$conditions}
                       ORDER BY inventory_id
                       {$limit}", $params);
  }
  
  public static function getCountByConditions($data)
  {
    $db = DB::getConnection();
    list($conditions, $params) = self::__getConditions($data);
   
    return $db->first("SELECT COUNT(*) AS t FROM inventory
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
