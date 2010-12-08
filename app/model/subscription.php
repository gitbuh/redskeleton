<?php

class Model_Subscription extends App_Model {
  
  public $metamodel = array(
    'name'  => 'subscription',
    'fields'=>array(
      'email'=>array(
        'type'  =>'string',
        'required'=>true,
      ),
      'zip'=>array(
        'title'   =>'Zip (postal) code',
        'type'  =>'numeric',
        'required'=>true,
      ),
    ),
  );
  
  /**
      Update - automatically called by RedBean when stored.
  */
  public function update () {
  
    parent::update();
    
    $test = R::findOne("subscription", "email=? and id<>?", array($this->email, $this->id));
    
    if ($test) $this->bean->id = $test->id;
    
  }
  
  
}

