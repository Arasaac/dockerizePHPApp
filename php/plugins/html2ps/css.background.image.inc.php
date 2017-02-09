<?php
// $Header: /cvsroot/html2ps/css.background.image.inc.php,v 1.13 2005/09/25 16:21:44 Konstantin Exp $

class CSSBackgroundImage extends CSSSubProperty {
  function default_value() { 
    return new BackgroundImagePDF(null); 
  }

  function parse($value) {
    // 'url' value
    if (preg_match("/url\((.*[^\\\\]?)\)/is",$value,$matches)) {
      $url = $matches[1];

      global $g_baseurl;
      return new BackgroundImagePDF(guess_url(css_remove_value_quotes($url), $g_baseurl));
    }

    // 'none' and unrecognzed values
    return new BackgroundImagePDF(null);
  }
}

?>