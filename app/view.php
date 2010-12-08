<?php
  
class App_View extends RedView_View {
  
  public function beforeRender () {
    // print_r($_SESSION);
  }
  
  //
  // protected
  //
  
  /**
      simple access control
  */
  protected static function access ($roles) {
    $user = self::getUser() or RedView::end('error', 'Log in first.');
    $rs = explode(',', trim($roles, ','));
    $us = explode(',', trim($user->roles, ','));
    foreach ($rs as $r) foreach ($us as $u) if ($r==$u) return $user;
    Slot::end('error', 'You don\'t have permission to do that.');
  }
  
  /**
      get user from session
  */
  protected static function getUser() {
    $user = R::dispense('user');
    $user->import($_SESSION['user']); 
    return $user; // $user->id ? $user : null;
  }
  
}

