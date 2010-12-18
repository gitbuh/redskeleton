<?php

class Model_Album extends App_Model {
  
  public $metamodel = array(
    'name'  => 'Album',
    'fields'=>array(
      'name'=>array(
        'title'=>'Album name',
        'required'=>true,
        'unique'=>true,
      ),
      'artist'=>array(
        'required'=>true,
      ),
      'published'=>array(
        'type'=>'date',
      ),
    ),
  );
  
}


