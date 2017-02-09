<?php 
session_start();
$id_usuario=$_SESSION['ID_USER'];
require ('../../../classes/languages/language_detect.php');
require('../../../funciones/funciones.php');
include_once ("../../../classes/querys/query.php");
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$query=new query();
$translate=$query->get_internacionalizacion_page_content($_SESSION['language'],27);

$dir="../../../temp/";
$borrar=CleanFiles($dir); //Borro los archivos temporales
$nombre_img=basename(tempnam("../../../temp",'tmp')); 

$imagen_original=$_POST['img'];
$extension = strtolower(substr(strrchr($imagen_original, "."), 1));

$nueva_imagen=$nombre_img.'.'.$extension;

copy ('../../../repositorio/originales/'.$imagen_original,'../../../temp/'.$nueva_imagen);

$ruta_cesto='ruta_cesto=temp/'.$nueva_imagen;
$encript->encriptar($ruta_cesto,1);

$ruta='img=../../temp/'.$nueva_imagen;
$encript->encriptar($ruta,1);
	
echo '<div id="products" style="height:40px; border:1px solid #CCC; padding: 5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'../../../images/add_3.png\' border="0" alt="'.$translate['add_seleccion'].'" title="'.$translate['add_seleccion'].'"></a> <a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');">'.$translate['add_seleccion'].'</a> | <a href="../../../inc/public/descargar.php?i='.$ruta.'""><img src=\'../../../images/download_3.png\' border="0" alt="'.$translate['descargar_simbolo'].'" title="'.$translate['descargar_simbolo'].'"></a> <a href="../../../inc/public/descargar.php?i='.$ruta.'"">'.$translate['descargar_simbolo'].'</a>';

if ($_SESSION['ID_USER'] != '' || $_SESSION['ID_USER']!=0) { 
	echo "&nbsp;<a href=\"javascript:void(0);\" onclick=\"return GB_show('Guardar Simbolo', '../gestionar_repositorio/mover_temp.php?img='+document.img_subida.imagen_actual.value+'&id_usuario=".$id_usuario."', 300, 550)\"><img src=\"../../../images/filesave.png\" alt=\"Guardar GIF animado\" title=\"Guardar GIF animado\" border=\"0\"/></a>";
}
	
echo '</div><br><div align="center"><img src=\'../../../temp/'.$nueva_imagen.'\'><form id="img_subida" name="img_subida" method="post\ action=""><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$nueva_imagen.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nueva_imagen.'"/></form></div>';



?>