<?php
// $Header: /cvsroot/html2ps/css.list-style-image.inc.php,v 1.3 2005/09/25 16:21:44 Konstantin Exp $

class CSSListStyleImage extends CSSSubProperty {
  // CSS 2.1: default value for list-style-image is none
  function default_value() { return null; }

  function parse($value) {
    if (preg_match('/url\(([^)]+)\)/',$value, $matches)) { 
      $url = $matches[1];

      if (strlen($url) === 0) { return null; }

      if ($url{0} === "'" || $url{0} === "\"") {
        $url = substr($url, 1, strlen($url)-2);
      };

      global $g_baseurl;
      $url = guess_url($url, $g_baseurl);

      return $url;
    };
    return null;
  }
}

?>