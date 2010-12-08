<?php 

class App_View_Widget_Register extends App_View_Widget {
  
  /**
      User registers
  */
  public static function register ( ) {
    $m = new Model_User;
    $bean = $m->createBean($_REQUEST);
    $_SESSION['user'] = $bean->export();
    RedView::end('message', 'Your account has been created.');
  }
  
}
