<?php 
require('../../funciones/funciones.php');
include_once ("../../classes/querys/query.php");
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$dir="../../temp/";
$borrar=CleanFiles($dir); //Borro los archivos temporales
$nombre_img=basename(tempnam("../../temp",'tmp')); 

$imagen_original=$_POST['img'];
$extension = strtolower(substr(strrchr($imagen_original, "."), 1));

$nueva_imagen=$nombre_img.'.'.$extension;

copy ('../../repositorio/originales/'.$imagen_original,'../../temp/'.$nueva_imagen);

$ruta_cesto='ruta_cesto=temp/'.$nueva_imagen;
$encript->encriptar($ruta_cesto,1);

$ruta='img=../../temp/'.$nueva_imagen;
$encript->encriptar($ruta,1);
	
echo '<div id="products" style="height:5px;" align="left"><a href="javascript:void(0);" onClick="sendData(\''.$ruta_cesto.'\');"><img src=\'images/cesto.gif\' border="0" alt="Añadir simbolo a mi cesto"></a><a href="inc/public/descargar.php?i='.$ruta.'""><img src=\'images/download1.png\' border="0" alt="Descargar simbolo"></a></div><br><div align="center"><img src=\'temp/'.$nueva_imagen.'\'><form id="img_subida" name="img_subida" method="post\ action=""><input name="imagen_subida" type="hidden" id="imagen_subida" value="'.$nueva_imagen.'"/><input name="imagen_actual" type="hidden" id="imagen_actual" value="'.$nueva_imagen.'"/></form></div>';



?>