<?php

class App_Model extends RedModel {
  
  public function onConstraintFail ($eventName, $sender, $message=null) {
    RedView::end('error', $message);
  }

}

