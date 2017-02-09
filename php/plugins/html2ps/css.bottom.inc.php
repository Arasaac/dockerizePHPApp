<?php
// $Header: /cvsroot/html2ps/css.bottom.inc.php,v 1.2 2005/09/25 16:21:44 Konstantin Exp $

class CSSBottom extends CSSProperty {
  function CSSBottom() { $this->CSSProperty(false, false); }
  function default_value() { return null; }
  function parse($value) { return units2pt($value); }
}

register_css_property('bottom', new CSSBottom);

?>