<?php
require_once('classes/querys/query.php');
require_once('classes/crypt/5CR.php');
require_once('configuration/key.inc');
require_once('funciones/funciones.php');

$query=new query();
$datos = $_GET['d']; 
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$encript->desencriptar($datos,2); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
$id_palabra=$datos['id_palabra'];
$id_idioma=$datos['id_idioma'];

if (isset($datos['id_palabra']) && $datos['id_palabra'] > 0) {
	$extension = strtolower(substr(strrchr($filename, "."), 1)); /* EXTRAIGO CUAL ES LA EXTENSIÓN DE LA IMAGEN TOMANDO EL PUNTO COMO CORTE */
	if ($id_idioma==0) {
		$datos_palabra=$query->datos_palabra($id_palabra);
		$file_name=utf8_decode($datos_palabra['palabra']);
		$file_name=str_replace(' ','%20',$file_name);
		$ruta=trim(file_get_contents("http://gtc3pc23.cps.unizar.es:8080/tts_servlet_unizar_cache_codec/sinte?sentence=".$file_name."&speaker=Jorge")); 
	} 
	
	$file_descarga=es_parser_con_241_209($file_name); 
	$file_descarga=str_replace(' ','_',$file_descarga);
	header ("Content-Disposition: attachment; filename=".$file_descarga.".wav");
	header ("Content-Type: application/octet-stream");
	readfile($ruta);

} 

?>
