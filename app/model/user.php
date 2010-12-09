<?php

class Model_User extends App_Model {
  
  public $metamodel = array(
    'name'  => 'user',
    'fields'=>array(
      'name'=>array(
        'title'=>'User Name',
        'required'=>true,
      ),
      'email'=>array(
        'unique'=>true,
        'required'=>true,
      ),
      'zip'=>array(
        'title'=>'Zip (postal) Code',
      ),
      'password'=>array(
        'required'=>true,
      ),
      'password2'=>array(
        'title'=>'Password Confirmation',
        'required'=>true,
      ),
    ),
  );
  
  /**
      Update - automatically caled by RedBean when stored.
  */
  public function update() {
    if ($this->password != $this->password2) {
      RedView::end('error', 'Password mismatch.');
    }
    parent::update();
    //sha1 pwd
    $this->bean->pwhash=sha1($this->password);
    $this->bean->remove('password');
    $this->bean->remove('password2');
  }
  
  
  /**
      User logs in
  */
  public static function login ($l, $p) {
    $user=R::findOne("user", "(@email=:l) and pwhash=:p", array('l'=>$l, 'p'=>sha1($p)));
    
    if (!$user) RedView::end('error', 'User name and password don\'t match.');
    
    $_SESSION['user']=$user->export();
    RedView::end('message', 'Logged in.');
  }
  
  /**
      User logs out
  */
  public static function logout ($l, $p) {
    session_unset();
    session_destroy();
  }
}


