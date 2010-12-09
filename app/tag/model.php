<?php

/** 
    Model tag

    Writes form fields defined in a model.

    Params:
      class - class or object with 'metamodel' property, 
              or a descendant of RedView_Meta_Model
 
*/
class App_Tag_Model extends RedView_ATag {
  
  /**
      Register with the parser
  */
  public static function register ($parser) {
    $parser->register('model', __CLASS__);
  }
  
  /**
      Manipulate XML when writing to cache.
      Call RedModel_Form::getFields 
  */
  public function markup ($parser) {
    
    $doc  = $parser->currentDocument;
    $node = $parser->currentNode;
    $frag = $doc->createDocumentFragment();
    
    $html = RedModel_Form::getFields($this->attribs['class']);
    
    $html = $parser->parseXml($html);

    $frag->appendXML($html);
    // die ($doc->saveXML($frag));
    
    $node->parentNode->replaceChild($frag, $node);
  }
    
  
}


