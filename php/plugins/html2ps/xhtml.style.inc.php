<?php
// $Header: /cvsroot/html2ps/xhtml.style.inc.php,v 1.4 2005/04/27 16:27:46 Konstantin Exp $

function process_style(&$html) {
  // Remove HTML comment bounds inside the <style>...</style> 
  $html = preg_replace("#(<style[^>]*>)\s*<!--#is","\\1",$html); 
  $html = preg_replace("#-->\s*(</style>)#is","\\1",$html);

  // Remove CSS comments
  while (preg_match("#(<style[^>]*>.*)/\*.*?\*/.*(</style>)#is",$html)) {
    $html = preg_replace("#(<style[^>]*>.*)/\*.*\*/(.*</style>)#is","\\1\\2",$html);
  };
}

?>