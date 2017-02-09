<?php
// $Header: /cvsroot/html2ps/ps.utils.inc.php,v 1.9 2005/07/28 17:04:33 Konstantin Exp $

define('MAX_IMAGE_ROW_LEN',8);
define('MAX_TRANSPARENT_IMAGE_ROW_LEN',8);

function trim_ps_comments($data) {
  $data = preg_replace("/(?<!\\\\)%.*/","",$data);
  return preg_replace("/ +$/","",$data);
}

function format_ps_color($color) {
  return sprintf("%.3f %.3f %.3f",$color[0]/255,$color[1]/255,$color[2]/255);
}
?>