<?php
// $Header: /cvsroot/html2ps/css.left.inc.php,v 1.2 2005/09/25 16:21:44 Konstantin Exp $

class CSSLeft extends CSSProperty {
  function CSSLeft() { $this->CSSProperty(false, false); }

  function default_value() { return 0; }

  function parse($value) {
    return units2pt($value);
  }

  function value2ps($value) {
    return $value;
  }
}

register_css_property('left', new CSSLeft);

?>