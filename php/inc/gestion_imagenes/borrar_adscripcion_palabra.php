<?php 
include ('../../classes/querys/query.php');

$query=new query();

$id_palabra=$_POST['id_palabra'];
$id_imagen=$_POST['id_imagen'];
$borrar_palabra=$query->delete_adscripcion_palabra($id_palabra,$id_imagen);

?>
