<?php 
include ('../../classes/querys/query.php');
include ('../../funciones/funciones.php');

$query=new query();

$id_usuario=$_POST['id'];
$borrar_usuario=$query->delete_usuario($id_usuario);

$target='../../usuarios/'.$id_usuario.'/';
$delete_dir=rmdir_recurse($target);
rmdir($target);

include ('tabla_usuarios.php');
?>
