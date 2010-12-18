<?php

/** 
    Panel tag

    Give elements with class "panel" some extra markup.
 
*/
class App_Tag_Panel extends RedView_ATag {
  
  /**
      Register with the parser
  */
  public static function register ($parser) {
    $parser->register('div', __CLASS__);
    $parser->register('span', __CLASS__);
    $parser->register('panel', __CLASS__);
  }
  
  /**
      Manipulate XML when writing to cache.
      Call RedModel_Form::getFields 
  */
  public function markup ($parser) {
    
    $doc  = $parser->currentDocument;
    $node = $parser->currentNode;

    $cssClass = @$this->attribs['class'];
    if (!($node->nodeName=='panel' || strpos("  $cssClass ", " panel "))) return;
    
    $frag = $doc->createDocumentFragment();
    
    $inner = $doc->createElement('span');
    $a = $doc->createAttribute('class');
    $a->value = ('panel-inner');
    $inner->appendChild($a);
    while ($node->hasChildNodes()) $inner->appendChild($node->firstChild);
    
    $node->appendChild($inner);
    
    $clearFix = $doc->createElement('div');
    $a = $doc->createAttribute('style');
    $a->value = ('clear:both;');
    $clearFix->appendChild($a);
    
    $inner->appendChild($clearFix);
    
    
    // $html = "<span class='panel-outer'>".$doc->saveXml($node)."</span>";

    // $frag->appendChild($node);
    // die ($doc->saveXML($frag));
    
    // $node->parentNode->insertBefore($frag, $node);
  }
    
  
}


