<?php

class User
{
  public static function editPassword($data)
  {
    $db = DB::getConnection();

    return $db->query("UPDATE account SET account_password = :password WHERE account_id = :account_id",
                      array(
                        "password" => password_hash($data->password_new, PASSWORD_DEFAULT),
                        "account_id" => $data->account_id
                      ));
  }
    
  public static function getById($user_id)
  {
    $db = DB::getConnection();
    
    return $db->first("SELECT * FROM account 
                       WHERE account_id = :account_id", array("account_id" => $user_id));
  }
  
  public static function getByUsername($username) 
  {
    $db = DB::getConnection();
    
    return $db->first("SELECT * FROM account WHERE account_username = :account_username", array("account_username" => $username));
  }
  
  public static function login($username, $password)
  {
    $db = DB::getConnection();
    $user = $db->first("SELECT * FROM account WHERE account_username = :username", array("username" => $username));

    if(password_verify($password, $user->account_password)) {
      return $user;
    } else {
      return false;
    }
  } 
  
  public static function recordLastLogin($account_id)
  {
    $db = DB::getConnection();

    return $db->query("UPDATE account SET account_last_login = :lastlogin WHERE account_id = :account_id",
                     array(
                       "lastlogin" => Date::getNowDateTime(),
                       "account_id" => $account_id
                     ));
  }
    
  public static function addStayLoginToken($account_id, $stay_login_token)
  {
    $db = DB::getConnection();

    $db->query("INSERT INTO stay_login(account_id, token, expire_date) VALUES(:account_id, :token, :expire_date)" , 
                array(
                   "account_id" => $account_id,
                   "token" => $stay_login_token,
                   "expire_date" => Date::getTomorrowDate()
                ));
  }
  
  public static function getByStayLoginToken($stay_login_token) 
  {
    $db = DB::getConnection();

    return $db->first("SELECT * FROM stay_login WHERE token = :token", array("token" => $stay_login_token));
  }

  public static function removeStayLoginToken($account_id, $stay_login_token)
  {
    $db = DB::getConnection();

    $db->query("DELETE FROM stay_login WHERE account_id = :account_id AND token = :token" ,
                array(
                  "account_id" => $account_id,
                  "token" => $stay_login_token
                ));
  }
}
