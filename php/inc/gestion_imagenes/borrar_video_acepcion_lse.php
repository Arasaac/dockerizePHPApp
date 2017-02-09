<?php 
include ('../../classes/querys/query.php');

$query=new query();

$id_imagen=$_POST['id'];
$borrar_video=$query->delete_video_acepcion_lse($id_imagen);

?>
