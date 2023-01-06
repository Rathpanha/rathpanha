<?php

class UserAuthentication 
{
  protected $user = null;

  /**
   * Check if the user has login
   * 
   * @return boolean TRUE if user has login or otherwise FALSE.
   */
  public function check()
  {
    // Already login and already has data retrieved
    if ($this->user !== null) {
      return true;
    }

    // Not yet retrieve information, but we have session
    if (isset($_SESSION['ACCOUNT_ID'])) {
      $user = User::getById($_SESSION['ACCOUNT_ID']);
      $this->user = $user;

      return true;
    }

    //Check if user stay_login or not
    if (isset($_COOKIE['_sl'])) {
      $stay_login = User::getByStayLoginToken($_COOKIE['_sl']);

      
      if ($stay_login) {//If user stay_login continue session
        $_SESSION['ACCOUNT_ID'] = $stay_login->account_id;
        $user = User::getById($_SESSION['ACCOUNT_ID']);
        User::recordLastLogin($user->account_id); //Record last login datetime
        $this->user = $user;
        
        //Check if token is expire create new token and remove old token
        if(strtotime($stay_login->expire_date) <= strtotime(Date::getNowDate())) {
          User::removeStayLoginToken($this->user->account_id, $_COOKIE['_sl']);

          $stay_login_token = $this->__generateSLToken();
          User::addStayLoginToken($user->account_id, $stay_login_token);
        }

        return true;
      }
    }

    return false;
  }

  /**
   * Attemp to login with a provided username and password
   * 
   * @param type $username
   * @param type $password
   * @return boolean TRUE if user has successfully login or otherwise FALSE.
   */
  public function attempt($username, $password, $stay_login) 
  {
    $user = User::login($username, $password);

    // if user exists, check if it is still active
    if ($user) {
      User::recordLastLogin($user->account_id); //Record last login datetime
      //If user check stay login add stay_login_token
      if ($stay_login) {
        $stay_login_token = $this->__generateSLToken();
        User::addStayLoginToken($user->account_id, $stay_login_token);
      }

      // create session that tell this user has been
      // successfully login
      $_SESSION['ACCOUNT_ID'] = $user->account_id;
      $this->user = $user;

      return true;
    }

    return false;
  }

  /**
   * Access to user information
   * 
   * @param type $name
   */
  public function __get($name)
  {
    if ($this->user != null) {
      return $this->user->$name;
    }
    return null;
    //var_dump($_SESSION);
    //throw new OutOfBoundsException();
  }

  public function isLogin() 
  {
    return isset($_SESSION['ACCOUNT_ID']);
  }

  /**
   * Logout user
   */
  public function logout() 
  {
    User::removeStayLoginToken($this->user->account_id, $_COOKIE['_sl']);
    setcookie('_sl', null, -1, '/');
    $this->user = null;

    unset($_SESSION['ACCOUNT_ID']);
    unset($GLOBALS[_SESSION]['ACCOUNT_ID']);
  }

  /**
   * Generate stay_login token
   */
  private function __generateSLToken() 
  {
    $stay_login_token = CustomString::rnd_code(100);

    //Create cookie for a week
    setcookie("_sl", $stay_login_token, time() + (10 * 365 * 24 * 60 * 60), "/");

    return $stay_login_token;
  }
}
