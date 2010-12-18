<?php

class App_Model extends RedModel {
  
  public function onConstraintFail ($eventName, $sender, $message=null) {
    die($message);
    RedView::end('error', $message);
  }

}

