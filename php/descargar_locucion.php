<?php
require_once('classes/querys/query.php');
require_once('classes/crypt/5CR.php');
require_once('configuration/key.inc');
require_once('funciones/funciones.php');
require ('classes/languages/language_detect.php');
require('classes/utf8/utf8.class.php');
/***************************************************/
/*    CODIFICACION DIFERENTES IDIOMAS           */
/***************************************************/

define("MAP_DIR","classes/utf8/MAPPING");
define("CP1250",MAP_DIR . "/CP1250.MAP");
define("CP1251",MAP_DIR . "/CP1251.MAP");
define("CP1252",MAP_DIR . "/CP1252.MAP");
define("CP1253",MAP_DIR . "/CP1253.MAP");
define("CP1254",MAP_DIR . "/CP1254.MAP");
define("CP1255",MAP_DIR . "/CP1255.MAP");
define("CP1256",MAP_DIR . "/CP1256.MAP");
define("CP1257",MAP_DIR . "/CP1257.MAP");
define("CP1258",MAP_DIR . "/CP1258.MAP");
define("CP874", MAP_DIR . "/CP874.MAP");
define("CP932", MAP_DIR . "/CP932.MAP");
define("CP936", MAP_DIR . "/CP936.MAP");
define("CP949", MAP_DIR . "/CP949.MAP");
define("CP950", MAP_DIR . "/CP950.MAP");
define("GB2312", MAP_DIR . "/GB2312.MAP");
define("BIG5", MAP_DIR . "/BIG5.MAP");

$utfConverter = new utf8(CP1251); //defaults to CP1250.
$utfConverter->loadCharset(CP1256);

$utfConverter_ru = new utf8(CP1251); //defaults to CP1250.
$utfConverter_ru->loadCharset(CP1251);

$utfConverter_ch = new utf8(GB2312); 
$utfConverter_ch->loadCharset(GB2312);

$query=new query();
$datos = $_GET['d']; //pasamos el paquete a una variable en nuestro caso es val
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$encript->desencriptar($datos,3); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
$ruta=$datos['mp3'];
$id_palabra=$datos['id_palabra'];
$id_idioma=$datos['id_idioma'];
$filename = $ruta; /* GUARDO EL NOMBRE DE LA IMAGEN */
if (isset($datos['id_palabra']) && $datos['id_palabra'] > 0) {
	$extension = strtolower(substr(strrchr($filename, "."), 1)); /* EXTRAIGO CUAL ES LA EXTENSIÓN DE LA IMAGEN TOMANDO EL PUNTO COMO CORTE */
	if ($id_idioma==0) {
		$datos_palabra=$query->datos_palabra($id_palabra);
		$file_name=$datos_palabra['palabra'];
	} else {
		$traduccion=$query->buscar_traduccion($id_palabra,$id_idioma);
		$datos_palabra=mysql_fetch_array($traduccion);
									
				switch ($id_idioma) {
									
						case 1: //RUSO
						$file_name=$utfConverter_ru->strToUtf8($datos_palabra['traduccion']);
						break;
									
						case 5: //BULGARO
						$file_name=$utfConverter_ru->strToUtf8($datos_palabra['traduccion']);
						break;
									
						default:
						$file_name=$datos_palabra['traduccion'];
						break;
									
				}
								
		
	}
	$file_descarga=es_parser_con_241_209($file_name); 
	$file_descarga=str_replace(' ','_',$file_descarga);
	header ("Content-Disposition: attachment; filename=".$file_descarga.".".$extension."");
	header ("Content-Type: application/octet-stream");
	header ("Content-Length: ".filesize($ruta));
	readfile($ruta);

} else {
	$file_descarga=str_replace('../','',$filename);
	$file_descarga=str_replace('_','',$file_descarga);
	//$file_descarga=str_replace('temp_','',$file_descarga);
	header ("Content-Disposition: attachment; filename=".$file_descarga."");
	header ("Content-Type: application/octet-stream");
	header ("Content-Length: ".filesize($ruta));
	readfile($ruta);
}
?>
