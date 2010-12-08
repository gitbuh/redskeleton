<?php 

class App_View_Widget_Login extends App_View_Widget {
  
  /**
      User logs in
  */
  public static function login () {
    $m = new Model_User;
    $m->login($_POST['l'], $_POST['p']);
  }
  /**
      User logs in
  */
  public static function logout () {
    $m = new Model_User;
    $m->logout();
  }
  
}
