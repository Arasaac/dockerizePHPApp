<?php 
session_start();
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');
include ('../../../classes/querys/query.php');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$query=new query();

require('../../../funciones/funciones.php');
include_once('../../../classes/zip/pclzip.lib.php');

$timestamp=time();
$fecha=date("d-m-Y",$timestamp);
		
$dir="../../../temp/";
$borrar=CleanFiles($dir); //Borro los archivos temporales
$nombre_zip=basename(tempnam("temp",'tmp')); 

$file = $nombre_zip.'.zip';

$archive = new PclZip($dir.$file);

if (isset($_GET['iddir']) && $_GET['iddir'] > 0) {

	$contenido_directorio=$query->contenido_directorio($_GET['iddir']);			
		
		 while ($row=mysql_fetch_array($contenido_directorio)) {
		 
		 
		 	if ($row['id_imagen'] > 0) {
			
		   		$archivo='../../../repositorio/originales/'.$row['file_name'];

			} elseif ($row['id_imagen'] == 0 && $row['id_simbolo'] == 0) {
			
				$archivo='../../../usuarios/'.$row['ruta_file'].'/'.$row['file_name'];
						  
			}
						
			$v_list = $archive->add($archivo,
                          PCLZIP_OPT_REMOVE_ALL_PATH);
		   
		 
		 }
		 

} else {

$folders=$query->listado_directorios_usuario($_SESSION['ID_USER']);
                                
while ($inf=mysql_fetch_array($folders)) {

	$contenido_directorio=$query->contenido_directorio($inf['id']);			
		
		 while ($row=mysql_fetch_array($contenido_directorio)) {
		 
		 
		 	if ($row['id_imagen'] > 0) {
			
		   		$archivo='../../../repositorio/originales/'.$row['file_name'];

			} elseif ($row['id_imagen'] == 0 && $row['id_simbolo'] == 0) {
			
				$archivo='../../../usuarios/'.$row['ruta_file'].'/'.$row['file_name'];
						  
			}
			
			// !!!! Importante definir la ruta
			$ruta=$row['ruta_file'].'/';
			//********************************
			
			$v_list = $archive->add($archivo,
                          PCLZIP_OPT_ADD_PATH, $ruta,
                          PCLZIP_OPT_REMOVE_ALL_PATH);
		   
		 
		 }
    
	}

} // Cierro el IF de comprobación de definicion de carpeta a comprimir
						  
  if ($v_list == 0) {
    die("Error : ".$archive->errorInfo(true));
  } else {
  echo '<div id="zip" style="height:100px;">';
  echo utf8_encode('Su archivo está listo<br>Pulse sobre la imagen para descargarlo<br /><br /><a href="../../temp/'.$file.'" target="_blank"><img src="../../images/zip.gif" alt="Descargar simbolos" border="0"><a>');
  echo '</div>';
  
  }



?>