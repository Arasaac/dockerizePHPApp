<?php 
include ('../../classes/querys/query.php');

$query=new query();

$nombre=utf8_decode($_POST['nombre']);
$empresa_institucion=utf8_decode($_POST['empresa_institucion']);
$web_autor=$_POST['web_autor'];
$email=$_POST['email'];

if ($_POST['accion']=="add" && $nombre !='') {

$comprobar_login=$query->comprobar_login($usuario);

	if ($comprobar_login==0) {
	
		$nuevo_autor=$query->add_autor($nombre,$empresa_institucion,$web_autor,$email);
	
	}

include ('tabla_autores.php');

} elseif ($_POST['accion']=="actualizar") {

$id_autor='';
$id_autor=$_POST['id_autor'];
$row_datos_autor=$query->datos_autor($id_autor);
	
$actualizar_autor=$query->actualizar_autor($id_autor,$nombre,$empresa_institucion,$web_autor,$email);

$row=$query->datos_autor($id_autor);
include ('tabla_autores.php'); 
} ?>
