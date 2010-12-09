<?php 

class App_View_Widget_Login extends App_View_Widget {
  
  /**
      User logs in
  */
  public static function login () {
    Model_User::login($_POST['l'], $_POST['p']);
  }
  /**
      User logs in
  */
  public static function logout () {
    Model_User::logout();
  }
  
}
