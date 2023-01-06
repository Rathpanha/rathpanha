<?php

class InventoryImport 
{
  public static function add($data)
  {
    $db = DB::getConnection();
    
    $inventories = array_map("intval", $data->inventories);   // Make sure that the type is a proper integer
    $inventories = implode(",", $inventories);
    
    $db->query(
      "INSERT INTO inventory_import(import_merchant_id, import_cart_big, import_cart_small, import_inventories, import_datetime, import_added_by, import_added_datetime)
      VALUES(IF(:merchant_id = '', NULL, :merchant_id), :cart_big, :cart_small, :inventories, :datetime, :added_by, :added_datetime)",
      [
        "merchant_id" => $data->merchant_id,
        "cart_big" => $data->cart_big,
        "cart_small" => $data->cart_small,
        "inventories" => $inventories,
        "datetime" => $data->datetime,
        "added_by" => $data->added_by,
        "added_datetime" => Date::getNowDateTime()
      ]);
    
    return $db->getLastInsertId();
  }
  
  public static function edit($data)
  {
    $db = DB::getConnection();
    
    $inventories = array_map("intval", $data->inventories);   // Make sure that the type is a proper integer
    $inventories = implode(",", $inventories);
    
    return $db->query("
      UPDATE inventory_import SET import_merchant_id = IF(:merchant_id = '', NULL, :merchant_id), import_cart_big = :cart_big, import_cart_small = :cart_small, import_inventories = :inventories, import_datetime = :datetime
      WHERE import_id = :import_id",
      [
        "merchant_id" => $data->merchant_id,
        "cart_big" => $data->cart_big,
        "cart_small" => $data->cart_small,
        "inventories" => $inventories,
        "datetime" => $data->datetime,
        "import_id" => $data->import_id
      ]
    );
  }
  
  public static function getById($import_id)
  {
    $db = DB::getConnection();
    
    return $db->first("
      SELECT inventory_import.*, merchant.merchant_id, merchant.merchant_name, GROUP_CONCAT(inventory.inventory_name SEPARATOR ', ') AS inventories FROM inventory_import
      LEFT JOIN merchant ON inventory_import.import_merchant_id = merchant.merchant_id
      INNER JOIN inventory ON FIND_IN_SET(inventory.inventory_id, inventory_import.import_inventories)
      WHERE inventory_import.import_id = :import_id
      GROUP BY inventory_import.import_id", ["import_id" => $import_id]);
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
    
    return $db->select("SELECT inventory_import.*, merchant.merchant_id, merchant.merchant_name, GROUP_CONCAT(inventory.inventory_name SEPARATOR ', ') AS inventories FROM inventory_import
                        LEFT JOIN merchant ON inventory_import.import_merchant_id = merchant.merchant_id
                        INNER JOIN inventory ON FIND_IN_SET(inventory.inventory_id, inventory_import.import_inventories)
                        {$conditions}
                        GROUP BY inventory_import.import_id
                        ORDER BY inventory_import.import_datetime
                        {$limit}", $params);
  }
  
  public static function getCountByConditions($data)
  {
    $db = DB::getConnection();
    list($conditions, $params) = self::__getConditions($data);
   
    return $db->first("
      SELECT COUNT(*) AS t FROM (
        SELECT COUNT(*) AS records FROM inventory_import
        LEFT JOIN merchant ON inventory_import.import_merchant_id = merchant.merchant_id
        INNER JOIN inventory ON FIND_IN_SET(inventory.inventory_id, inventory_import.import_inventories)
        {$conditions}
        GROUP BY inventory_import.import_id        
      ) r", $params)->t;
  }
  
  private static function __getConditions($data)
  {
    $conditions = "WHERE true";
    $params = array();
    
    if(isset($data->date)) {
      $conditions = " AND DATE(inventory_import.import_datetime) = :date";
      $params['date'] = $data->date;
    }

    //var_dump($data, $conditions, $params); exit();
    return array($conditions, $params);
  }
  
  //This function is to push html span between every inevntory's name
  public static function convertInventoryNameToHTML($inventories, $separator = ", ") 
  {
    $inventories = explode($separator, $inventories);
    $results = [];
    foreach($inventories as $key => $name) {
      $inventory = "<div style='padding-right: 0.25rem;'>" . $name . ($key + 1 < count($inventories) ? $separator : "") . "</div>";
      $results[] = $inventory;
    }
    
    return "<div class='flexbox wrap'>" .implode("", $results) . "</div>";
  }
}
