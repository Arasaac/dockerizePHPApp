<?php 
session_start();
require('../../funciones/funciones.php');
include_once('../../classes/zip/pclzip.lib.php');
include ('../../classes/querys/query.php');
require ('../../classes/languages/language_detect.php');

$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],12); 

$id_material=$_GET['id_material'];
//echo $id_material;
$material=$query->datos_material($id_material);

$archivos=array();

$directorio_materiales = opendir('../../zona_descargas/materiales/'.$id_material.'/');
		while (false !== ($archivo = readdir($directorio_materiales))) {
			if ($archivo != "." && $archivo != "..") {
				$archivos[]='../../zona_descargas/materiales/'.$id_material.'/'.$archivo;
				/*echo $archivo.'<br/>';*/
			}
	}
		
$dir="../../temp/";
$borrar=CleanFiles($dir); //Borro los archivos temporales
$nombre_zip=basename(tempnam("temp",'tmp')); 

$file = es_parser_con_241_209($material['material_titulo']).'_'.$nombre_zip.'.zip';

$archive = new PclZip($dir.$file);

$v_list = $archive->add($archivos, PCLZIP_OPT_REMOVE_PATH,'../../zona_descargas/materiales/'.$id_material.'/');
						  
  if ($v_list == 0) {
    die("Error : ".$archive->errorInfo(true));
  } else {
  echo '<div id="zip" style="height:100px;">';
  echo utf8_encode(''.$translate['archivo_listo'].'<br>'.$translate['pulse_imagen_descargar'].'<br /><br /><a href="temp/'.$file.'" target="_blank"><img src="images/zip.gif" alt="'.$translate['descargar'].'" title="'.$translate['descargar'].'" border="0"><a>');
  echo '</div>';
  
  }



?>