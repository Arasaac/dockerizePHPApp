<?php 
session_start();
require('funciones/funciones.php');
include_once('classes/zip/pclzip.lib.php');
include ('classes/querys/query.php');
$query=new query();

$archivos=array();

	foreach ($_POST['file'] as $key => $value) {
	
			$row=$query->datos_imagen($value);
			
			if ($row['extension']=='flv') { 
				$archivos[]='repositorio/LSE_acepciones/'.$row['imagen'].'';
			} else {
				$archivos[]='repositorio/originales/'.$row['imagen'].'';
			}
			
	}

$archivos_sin_suplicados=limpiarArray($archivos);

$dir="temp/";
$borrar=CleanFiles($dir); //Borro los archivos temporales
$nombre_zip=basename(tempnam("temp",'tmp')); 

$file = $nombre_zip.'.zip';

$archive = new PclZip($dir.$file);
$a_descargar=$dir.$file;

$v_list = $archive->add($archivos_sin_suplicados,
							PCLZIP_OPT_REMOVE_ALL_PATH);
						  
    // Set headers
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$a_descargar");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");
	
	readfile($a_descargar);


?>