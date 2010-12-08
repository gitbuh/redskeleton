<?php

class App_View_Page_Test extends App_View_Page implements RedView_IRemote {

  public static function register () {
    $user=R::dispense('user');
    $user->import($_REQUEST, 'name,email,zip,password,password2,roles');
    R::store($user);
  }

}
