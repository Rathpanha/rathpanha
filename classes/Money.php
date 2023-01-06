<?php

class Money 
{
  public static $types = array(
    1 => "ប្រាក់សាងសង់ទីលានរទេះ",
    2 => "ប្រាក់អគ្គិសនីនិងទឹក"
  );
  
  public static function add($data)
  {
    $db = DB::getConnection();
    
    return $db->query("INSERT INTO money(money_amount_income, money_amount_expense, money_date, money_added_datetime, money_added_by, money_note, money_type)
                       VALUES(:amount_income, :amount_expense, :date, :added_datetime, :added_by, IF(:note = '', NULL, :note), :type)", [
                        "amount_income" => $data->amount_income ? $data->amount_income : 0,
                        "amount_expense" => $data->amount_expense ? $data->amount_expense : 0,
                        "date" => $data->date,
                        "added_datetime" => Date::getNowDateTime(),
                        "added_by" => $data->added_by,
                        "note" => $data->note,
                        "type" => $data->type
                       ]);
  }
  
  public static function edit($data)
  {
    $db = DB::getConnection();
    
    return $db->query("UPDATE money SET money_amount_income = :amount_income, money_amount_expense = :amount_expense, money_date = :date, money_note = IF(:note = '', NULL, :note), money_type = :type
                       WHERE money_id = :id", [
                         "amount_income" => $data->amount_income ? $data->amount_income : 0,
                         "amount_expense" => $data->amount_expense ? $data->amount_expense : 0,
                         "date" => $data->date,
                         "note" => $data->note,
                         "type" => $data->type,
                         "id" => $data->money_id
                       ]);

  }
  
  
  public static function getById($money_id)
  {
    $db = DB::getConnection();
    
    return $db->first("SELECT * FROM money WHERE money_id = :money_id", ["money_id" => $money_id]);
  }
  
  public static function getByDateAndType($date, $type)
  {
    $db = DB::getConnection();
    
    return $db->first("SELECT * FROM money WHERE money_date = :date AND money_type = :type", [
            "date" => $date,
            "type" => $type
          ]);
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
    
    return $db->select("SELECT * FROM money
                       {$conditions}
                       ORDER BY money_date
                       {$limit}", $params);
  }
  
  public static function getCountByConditions($data)
  {
    $db = DB::getConnection();
    list($conditions, $params) = self::__getConditions($data);
   
    return $db->first("SELECT COUNT(*) AS t FROM money
                      {$conditions}", $params)->t;
  }
  
  private static function __getConditions($data)
  {
    $conditions = "WHERE true";
    $params = array();
    
    if(isset($data->start_date) && isset($data->end_date)) {
      $conditions .= " AND money_date BETWEEN :start_date AND :end_date";
      $params['start_date'] = $data->start_date;
      $params['end_date'] = $data->end_date;
    } else {
      if(isset($data->start_date)) {
        $conditions .= " AND money_date >= :start_date";
        $params['start_date'] = $data->start_date;
      } else if(isset($data->end_date)) {
        $conditions .= " AND money_date <= :end_date";
        $params['end_date'] = $data->end_date;
      }
    }
    
    if(isset($data->type)) {
      $conditions .= " AND money_type = :money_type";
      $params['money_type'] = $data->type;
    }

    //var_dump($data, $conditions, $params); exit();
    return array($conditions, $params);
  }
}
