<?php 
include ('../../classes/querys/query.php');

$query=new query();

$id_imagen=$_POST['id'];
$borrar_imagen=$query->delete_imagen($id_imagen);

?>
