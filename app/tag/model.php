<?php

/** 
    override forms 
*/
class App_Tag_Model extends RedView_ATag {
  
  public static function register ($parser) {
    $parser->register('model', __CLASS__);
  }
  
  /**
      Put a node before this node when writing to cache
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


