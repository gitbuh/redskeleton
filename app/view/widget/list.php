<?php

class App_View_Widget_List extends App_View_Widget {

  public static $fields='name,info';

  /**
      Create a mailing list
  */
  public static function createList () {
    self::access('admin');
    Model_List::createBean($_REQUEST);
    RedView::end('message', 'List created.');
  }
  
  /**
      Update a mailing list
  */
  public static function updateList () {
    self::access('admin');
    Model_List::updateBean($_REQUEST);
    RedView::end('message', 'List updated.');
  }

}

