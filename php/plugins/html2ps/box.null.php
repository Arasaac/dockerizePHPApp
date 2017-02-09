<?php
// $Header: /cvsroot/html2ps/box.null.php,v 1.9 2005/09/14 04:03:55 Konstantin Exp $

class NullBoxPDF extends GenericBoxPDF {
  function get_min_width(&$context) { return 0; }
  function get_max_width(&$context) { return 0; }
  function get_height() { return 0; }

  function NullBoxPDF() {
    // No CSS rules should be applied to null box
    push_css_defaults();
    $this->GenericBoxPDF();
    pop_css_defaults();
  }
  
  function &create($pdf, &$root) { 
    $box =& new NullBoxPDF;
    return $box; 
  }
  function show(&$pdf) {}

  function reflow(&$parent, &$context) {
    // Move current "box" to parent current coordinates. It is REQUIRED, 
    // as some other routines uses box coordinates.
    $this->put_left($parent->get_left());
    $this->put_top($parent->get_top());
  }

  function is_null() { return true; }

  function to_ps(&$psdata) { 
    // Just do nothing
  }
}
?>