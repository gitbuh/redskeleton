<?php

class App_View_Page_Admin_Edit extends App_View_Page implements RedView_IRemote {

  public $beanType;
  public $fields;
  public $name;
  public $id;
    
  public function __construct () {
    
    //if ($_REQUEST['_rv:data']) die('asdasd');
    
    $this->beanType = RedView::args(1);
    $this->id = RedView::args(2);
    $model = "Model_{$this->beanType}";
    
    if (!class_exists($model)) return;

    $this->name = ucwords($this->beanType);
    
    $bean=null;
    if ($this->id) {
      $bean = R::load($this->beanType, $this->id);
      if (!$bean->id) return RedView::end('error', "{$this->name} not found.");
    }
    
    $gridFields; $gridCols; $gridRows;
    $fields = RedModel_Form::getFields($model);
    $o = new $model();
    $fieldList = explode(',', $o->getFieldList($this->id ? 'update' : 'create')); 
    $listFieldList = explode(',', $o->getFieldList('list')); 
    
    $class = get_class($this);
    $html='';
    
    $gridFields[] = array('name'=>'id', 'type'=>'text');
    
    $gridCols[]=array('id'=>'id', 'header'=>'ID');
    
    foreach ($fields as $k=>$v) {
      
      $gridField;
      $gridField['name'] = $k;
      $gridField['type'] = 'text';
          
      $gc;
      $gc['width'] = 100;
      $gc['id'] = $k;
      $gc['header'] = @$v->constraints['title']->value;
      $gc['header'] || $gc['header'] = ucwords($k);
      
      $value = htmlentities(''.@$_SESSION['_rv']['fields'][$class][$k]);
      $value || $value = $value = @$bean->$k;
      $fieldType = @$v->constraints['type']->value;
        
      if ($fieldType && ucwords($fieldType{0})==$fieldType{0}) {
      
        $gridField['type'] = 'select';
      
        $beans = R::find(strtolower($fieldType));
        
        $gc['editor'] = array('type'=>'select', 'options'=>array());
        foreach ($beans as $b) {
          $gc['editor']['options'][$b->id] = $b->name; 
        }
        // sentinel... needs to be js identifier, but JSON can only store strings
        $gc['renderer']='~~~FK~~~'; 
        
        $opts='';
        foreach ($beans as $b) {        
          $sel = $b->id == $value ? ' selected="selected"' : '';
          $opts.= "<option value='{$b->id}'$sel>{$b->name}</option>";
        }
        $html.="<label>{$v->title}<select name=\"{$k}\">$opts</select></label>";
        
      }
      else {     
            
        $click='';
        switch ($fieldType) {
          case 'int': case 'integer': case 'integral':
            //Valid rules. Array element could be 'R' - Required 'N' - Number 'E' - Email 'F' - Float
            $gc['editor'] = array('type'=>'text', 'validRule'=>array('N'));
            break;
          case 'numeric': case 'number': case 'decimal': case 'real': case 'float':  case 'double': 
            $gc['editor'] = array('type'=>'text', 'validRule'=>array('F'));
            break;
          case 'date': 
            $gc['editor'] = array('type'=>'date');
            $fmt='%y-%m-%d';
            $click="onclick='Calendar.trigger({inputField:this})' onchange='this.value=this.value.replace(/\\//g,\"-\")'";
            break;
          default:
            $gc['editor'] = array('type'=>'text');
        }
        
        if (in_array($k, $fieldList)) {
          $html.="<label>{$v->title}<input type=\"text\" name=\"$k\" value=\"$value\" $click/></label>";
        }
      }
      if (in_array($k, $listFieldList)) {
        $gridFields[]=$gridField;
        $gridCols[]=$gc;
      }
    }
    unset($_SESSION['_rv']['fields'][$class]);
    
    $this->set('fields', $html);
    $this->set('gridFields', $gridFields);
    $this->set('gridCols', str_replace('"~~~FK~~~"', 'renderOptionText', json_encode($gridCols)));
    
    $this->set('gridAction', urlencode(RedView_Action::encodeRequest($this, 'gridAction')));
    
    $this->getListData();
    
  }
  
  protected function getListData () {
  
    $type = $this->beanType;
    $beans = R::find(strtolower($type)); 
    
    $m = "Model_$type";
    $o = new $m();
    
    $fields = explode(',', $o->getFieldList('list'));
    
    // $fields = RedModel_Form::getFields("Model_$type");
    $gridRows;
    // foreach ($beans as $bean) {
    foreach ($beans as $k=>$bean) {
      $row; $objRow;
      $row[]=$bean->id;
      $objRow['id']=$bean->id;
      foreach ($fields as $v) {
        $row[]=@$bean->$v->id ? $bean->$v->id : $bean->$v;
        $objRow[$v]=@$bean->$v->id ? $bean->$v->id : $bean->$v;
      }
      $gridRows[] = $row;
      $gridObjRows[] = $objRow;
    }
    $this->set('gridRows', $gridRows);
    $this->set('gridObjRows', $gridObjRows);
  }
  
  public function edit () {
    $this->beanType = RedView::args(1);
    $this->id = RedView::args(2);
    $model = "Model_{$this->beanType}";
    if ($this->id) {
      $_REQUEST['id'] = $this->id;
      $model::updateBean($_REQUEST);
    }
    else {
      $model::createBean($_REQUEST);
    }
    $verb = $this->id ? "updated" : "created";
    RedView::end('message', "{$this->name} $verb.");
  }
  
  public function gridAction () {
    $data = json_decode($_REQUEST['_gt_json']);
    if ($data->action=='load') {
      echo $this->toJson(); 
      exit(0);
    }
    elseif ($data->action=='save') {
      // print_r($data); die;
      $this->beanType = RedView::args(1);
      $model = "Model_{$this->beanType}";
      
      foreach ($data->insertedRecords as $record) {
        $model::createBean($record);
      }
      
      foreach ($data->updatedRecords as $record) {
        $model::updateBean($record);
      }
      
      foreach ($data->deletedRecords as $record) {
        $model::deleteBean($record);
      }
      exit(0);
    }
  }
  
  protected function toJson () {
    
	  $a = array(
	    'recordType'=>'object',
	    'pageInfo'=>array('totalRowNum'=>2),
	    // 'fields'=>$this->get('gridFields'),
	    'data'=>$this->get('gridObjRows'),
    );
    return json_encode($a);
  }

}
