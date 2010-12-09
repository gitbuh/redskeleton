<?php

class App_View_Widget_Subscribe extends App_View_Widget {

  public function beforeRender () {
    parent::beforeRender();
    $listsAvailable = R::find('list');
    $html='';
    foreach ($listsAvailable as $l) {
      $html .= "<option value='{$l->id}'>{$l->name}</option>";
    }
    $this->listsAvailable=$html;
    $user=self::getUser();
    if (!($user && $user->id)) return;
    $inLists = R::related($user, 'list');
    $html='';
    foreach ($inLists as $l) {
      $html .= "<li value='{$l->id}'>{$l->name}</li>";
    }
    $this->inLists="<ul>$html</ul>";
  }

  
  /**
      User adds himself to a mailing list
  */
  public static function subscribe () {  
    
    if (!$_REQUEST['list']) return RedView::set('error', "Choose a list.");
    
    $list = R::load('list', $_REQUEST['list']);
    
    if (!$list->id) return RedView::set('error', "List doesn't exist.");
    
    $scrip = Model_Subscription::createBean($_REQUEST);
    $scrip->main = self::getUser();
    R::associate($list, $scrip);
    // R::store($list);
    // R::store($scrip);
    $_SESSION['user'] = $scrip->main->export();
    return RedView::set('message', 'Success!');
  }
  
  /**
      User removes himself from a mailing list
  */
  public static function unsubscribe () {
    $user=self::getUser();
    if (!$user) return RedView::set('error', "You're not on any of our lists.");
    if (!$list=self::getList()) return RedView::set('error', "List doesn't exist.");
    R::unassociate($list, $user);
  }
  
}


