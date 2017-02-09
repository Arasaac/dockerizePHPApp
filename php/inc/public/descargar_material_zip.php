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
$indice_html=generar_ficha($translate,$material,$query);
$archivo_indice = fopen('../../zona_descargas/materiales/'.$id_material.'/index.html', "w+");
fwrite($archivo_indice,$indice_html);
fclose($archivo_indice);

$archivos=array();

$directorio_materiales = opendir('../../zona_descargas/materiales/'.$id_material.'/');
		while (false !== ($archivo = readdir($directorio_materiales))) {
			if ($archivo != "." && $archivo != "..") {
				$archivos[]='../../zona_descargas/materiales/'.$id_material.'/'.$archivo;
			}
	}
$archivos[]='../../images/arasaac.jpg';
$archivos[]='../../images/minilogo_aragob.gif';

$dir="../../temp/";
$borrar=CleanFiles($dir); //Borro los archivos temporales
$nombre_zip=basename(tempnam("temp",'tmp')); 

$file = $material['id_material'].'_'.es_parser_con_241_209($material['material_titulo']).'.zip';

$a_reemplazar1 = array("¿","?");
$a_reemplazar2 = array("/");
$a_reemplazar3 = array("â€™");
$a_reemplazar4 = array("ñ");
$a_reemplazar5 = array("Ñ");

$filtrado1 = str_replace($a_reemplazar1, "",$file);
$filtrado2 = str_replace($a_reemplazar2, "-", $filtrado1);
$filtrado3 = str_replace($a_reemplazar3, "", $filtrado2);
$filtrado4 = str_replace($a_reemplazar4, "n", $filtrado3);
$filtrado5 = str_replace($a_reemplazar5, "N", $filtrado4);

$a_descargar=$dir.$filtrado5;

if (!file_exists($a_descargar)) {
	$archive = new PclZip($dir.$filtrado5);
	$v_list = $archive->add($archivos, PCLZIP_OPT_REMOVE_ALL_PATH);

	  if ($v_list == 0) {
		die("Error : ".$archive->errorInfo(true));
	  } else {
	  	echo '<div id="zip" style="height:100px;">';
	  	echo $translate['archivo_listo'].'<br>'.$translate['pulse_imagen_descargar'].'<br /><br /><a href="temp/'.$filtrado5.'" target="_blank"><img src="images/zip.gif" alt="'.$translate['descargar'].'" title="'.$translate['descargar'].'" border="0"><a>';
	 	 echo '</div>';
	  
	  }

} else {
	
		echo '<div id="zip" style="height:100px;">';
	  	echo $translate['archivo_listo'].'<br>'.$translate['pulse_imagen_descargar'].'<br /><br /><a href="temp/'.$filtrado5.'" target="_blank"><img src="images/zip.gif" alt="'.$translate['descargar'].'" title="'.$translate['descargar'].'" border="0"><a>';
	 	echo '</div>';
}
?>