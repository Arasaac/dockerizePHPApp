<?php
	$ruta=$_GET['d'];
	$filename =array_pop(explode('/',$ruta));
	$file_descarga=str_replace(' ','_',$filename);
	//$file_descarga=str_replace('_','',$file_descarga);
	header ("Content-Disposition: attachment; filename=".$file_descarga."");
	header ("Content-Type: application/octet-stream");
	header ("Content-Length: ".filesize($ruta));
	readfile($ruta);
?>
