<?php 
session_start();
require_once('classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

require('../../funciones/funciones.php');
include_once('classes/zip/pclzip.lib.php');

$archivos=array();

if (isset($_SESSION['cart']) && $_SESSION['cart'] !="") {
	
	foreach ($_SESSION['cart'] as $key => $value) {
	
			$encript->desencriptar($key,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
			$ruta='../../'.$key['ruta_cesto'];
	
	$archivos[]=$ruta;

	}

}

$timestamp=time();
$fecha=date("d-m-Y",$timestamp);
		
$dir="../../temp/";
$borrar=CleanFiles($dir); //Borro los archivos temporales
$nombre_zip=basename(tempnam("temp",'tmp')); 

$file = $nombre_zip.'.zip';

$archive = new PclZip($dir.$file);

$v_list = $archive->add($archivos,
							PCLZIP_OPT_REMOVE_ALL_PATH,
                            PCLZIP_OPT_ADD_PATH, 'arasaac_'.$fecha.'');
						  
  if ($v_list == 0) {
    die("Error : ".$archive->errorInfo(true));
  } else {
  echo '<div id="zip" style="height:100px;">';
  echo utf8_encode('Su archivo está listo<br>Pulse sobre la imagen para descargarlo<br /><br /><a href="../../temp/'.$file.'" target="_blank"><img src="../../images/zip.gif" alt="Descargar simbolos" border="0"><a>');
  echo '</div>';
  
  }
?>