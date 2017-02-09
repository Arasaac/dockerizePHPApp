<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$query=new query();
$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$id_directorio=$_POST['id_directorio'];
$nivel=$_POST['nivel'];
$id_usuario=$_POST['id_usuario'];
$parent=$_POST['parent'];

/*echo 'ID Directorio:'.$id_directorio;
echo 'Nivel:'.$nivel;
echo 'ID Usuario:'.$id_usuario;
echo 'Parent'.$parent;*/

if (isset($_POST['thelist2']) && $_POST['thelist2'] !='') { 

  foreach ($_POST['thelist2'] as $indice=>$valor){ 


	$encript->desencriptar($valor,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
	$ruta='ruta_cesto='.$valor['ruta_cesto'];
	/*$encript->encriptar($ruta,1); 
	$_SESSION['mi_seleccion'][$ruta] = 1;*/
	
	$ruta = str_replace("ruta_cesto=", "", $ruta);
	$ruta = str_replace("repositorio/", "", $ruta);
	$ruta=explode("/", $ruta);
		
	if ($ruta[0] == 'originales') {

		$id_imagen=explode(".",$ruta[1]);
		$imagen=$query->datos_imagen($id_imagen[0]);
		
		$name=$ruta[1];
		$id_palabra=$imagen['id_palabra'];
		$id_imagen=$imagen['id_imagen'];
		$id_tipo_imagen=$imagen['id_tipo_imagen'];
		
		$add_repositorio=$query->add_original_repositorio($name,$id_directorio,$id_palabra,$id_imagen,$id_tipo_imagen,$id_usuario);

	
	} elseif ($ruta[0] == 'temp') {
	
		$name=$ruta[1];
		$dir=$query->datos_directorio($id_directorio,$id_usuario);
		
		if ($dir['parent']==0) { $directorio=$id_usuario; } else { $directorio=$dir['ruta_dir']; }
		
		$add_repositorio=$query->add_temp_repositorio($name,$id_directorio,$directorio,$id_usuario);
	
	
	}
	
  } //Cierro el foreach

} // Cierro el IF
?>