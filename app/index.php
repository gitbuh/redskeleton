<?php

set_include_path(get_include_path().PATH_SEPARATOR.dirname(__FILE__).PATH_SEPARATOR.dirname(__FILE__).'/..');

require_once '../lib/redbean/RedBean/redbean.inc.php';
require_once '../lib/redmodel/redmodel.php';
require_once '../lib/redview/redview.php';

R::setup("mysql:host=localhost;dbname=redskeleton","root","root"); 

$optimizer = new RedBean_Plugin_Optimizer( R::$toolbox ); 
R::$redbean->addEventListener("update", $optimizer); 

RedView::setup();

