<?php

class Model_List extends App_Model {
  
  public $metamodel = array(
    'name'  => 'list',
    'fields'=>array(
      'name'=>array(
        'title'   =>'List name',
        'unique'  =>true,
        'required'=>true,
      ),
      'info'=>array(
      ),
    ),
  );
  
  /**
      Update - automatically called by RedBean when stored.
  */
  public function update() {
    parent::update();
  }

  /**
      get list from query string or default list
  */
  public static function getList($id) {
    $list = R::load('list', $id);
    return $list->id ? $list : null;
  }
  
  
}

