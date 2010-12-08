<?php

class App_View_Widget_List extends App_View_Widget {

  public static $fields='name,info';

  /**
      Create a mailing list
  */
  public static function createList () {
    $user=self::access('admin');
    $m = new Model_List();
    $e = $m->createBean($_REQUEST);
    RedView::end('message', 'List created.');
  }
  
  /**
      Update a mailing list
  */
  public static function updateList () {
    $user=self::access('admin');
    $m = new Model_List();
    $e = $m->updateBean($_REQUEST);
    RedView::end($e ? 'error' : 'message', $e ? 'List not found.' : 'List updated.');
  }

}

