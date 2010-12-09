<?php 

class App_View_Widget_Login extends App_View_Widget {
  
  /**
      User logs in
  */
  public static function login () {
    Model_User::login($_REQUEST['l'], $_REQUEST['p']);
  }
  /**
      User logs in
  */
  public static function logout () {
    Model_User::logout();
  }
  
}
