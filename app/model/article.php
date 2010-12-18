<?php

class Model_Article extends App_Model {
  
  public $metamodel = array(
    'name'  => 'article',
    'fields'=>array(
      'name'=>array(
        'title'=>'Short name',
        'required'=>true,
        'unique'=>true,
      ),
      'title'=>array(
        'required'=>true,
      ),
      'body'=>array(
        'type'=>'text',
      ),
      'published'=>array(
        'type'=>'date',
      ),
    ),
  );
  
}


