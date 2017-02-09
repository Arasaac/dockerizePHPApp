<?php 
session_start();
include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$query=new query();

$file_id=$_POST['id_file'];

if (isset($_POST['s']) && $_POST['s']>0) {

	$simbolos_seleccion=$query->datos_simbolos_seleccion($_POST['s'],$_SESSION['ID_USER']);
	while ($row=mysql_fetch_array($simbolos_seleccion)) {
	
			if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
			elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
			
			$ruta_img='size=50&ruta=../../../../'.$ruta;
			$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
			$ruta_cesto='ruta_cesto='.$ruta;
			$encript->encriptar($ruta_cesto,1); 
			$_SESSION['mi_seleccion'][$id_file] = 1;
			print "<li id=\"thelist2_".$row['file_id']."\"><a href=\"javascript:void(0)\"><img src=\"classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a></li>";
			
	}
	
	$_SESSION['mi_seleccion'][$file_id] = 1;
	
	foreach ($_SESSION['mi_seleccion'] as $key => $value) {
	
		if ($key > 0 && $key != '') {
				$row=$query->datos_archivo_repositorio($key);
				
				if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
				elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
				
				$ruta_img='size=50&ruta=../../'.$ruta;
				$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
				$ruta_cesto='ruta_cesto='.$ruta;
				$encript->encriptar($ruta_cesto,1); 
				
				print "<li id=\"thelist2_".$key."\"><a href=\"javascript:void(0)\"><img src=\"../../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a></li>";
		}
	}	
	
} elseif (!isset($_GET['s']))   {

	$_SESSION['mi_seleccion'][$file_id] = 1;
	
	foreach ($_SESSION['mi_seleccion'] as $key => $value) {
	
				$row=$query->datos_archivo_repositorio($key);
				
				if ($row['id_imagen']==0 && $row['id_simbolo']==0) { $ruta='usuarios/'.$row['ruta_file'].'/'.$row['file_name']; }
				elseif ($row['id_imagen'] > 0 && $row['id_simbolo']==0) {  $ruta='repositorio/originales/'.$row['file_name']; } 
				
				$ruta_img='size=50&ruta=../../'.$ruta;
				$encript->encriptar($ruta_img,1); //OJO uno(1) es para encriptar variables para URL	
				$ruta_cesto='ruta_cesto='.$ruta;
				$encript->encriptar($ruta_cesto,1); 
				
				print "<li id=\"thelist2_".$key."\"><a href=\"javascript:void(0)\"><img src=\"../../classes/img/thumbnail.php?i=".$ruta_img."\" border=\"0\"/></a></li>";
	}			

}
?>
