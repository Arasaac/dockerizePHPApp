<?php
// $Header: /cvsroot/html2ps/css.pseudo.align.inc.php,v 1.10 2005/09/25 16:21:44 Konstantin Exp $

define('PA_LEFT',0);
define('PA_CENTER',1);
define('PA_RIGHT',2);

// This is a pseudo CSS property for 

class CSSPseudoAlign extends CSSProperty {
  function CSSPseudoAlign() { $this->CSSProperty(true, true); }
  function default_value() { return PA_LEFT; }

  function inherit() {
    // This pseudo-property is not inherited by tables
    // As current box display value may not be know at the moment of inheriting, 
    // we'll use parent display value, stopping inheritance on the table-row/table-group level

    // Determine parent 'display' value
    $handler =& get_css_handler('display');
    $parent_display = $handler->get_parent();
    
    if ($parent_display === "table") {
      $this->push($this->default_value());
      return;
    }

    $this->push($this->get());
  }

  function parse($value) {
    // Convert value to lower case, as html allows values 
    // in both cases to be entered
    //
    $value = strtolower($value);    

    if ($value === 'left') { return PA_LEFT; }
    if ($value === 'right') { return PA_RIGHT; }
    if ($value === 'center') { return PA_CENTER; }

    // For compatibility with non-valid HTML
    //
    if ($value === 'middle') { return PA_CENTER; }

    return $this->default_value();
  }

  function value2ps($value) {
    switch ($value) {
    case PA_LEFT:
      return "{text-align-left}";
    case PA_RIGHT:
      return "{text-align-right}";
    case PA_CENTER:
      return "{text-align-center}";
    default:
      return "{text-align-left}";
    }
  }

  function ps($writer) {
    $writer->write("dup get-box-dict /PseudoAlign ".$this->value2ps($this->get())." put\n");
  }

  function value2pdf($value) { 
    switch ($value) {
    case PA_LEFT:
      return "ta_left";
    case PA_RIGHT:
      return "ta_right";
    case PA_CENTER:
      return "ta_center";
    default:
      return "ta_left";
    }
  }
}

register_css_property('-align', new CSSPseudoAlign);

?>