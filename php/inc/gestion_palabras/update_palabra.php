<?php
session_start();
 
include ('../../classes/querys/query.php');

$query=new query();

$palabra=$_POST['palabra'];
$id_palabra=$_POST['id_palabra'];

$datos_palabra=$query->update_palabra($id_palabra, $_POST['PickList'],$palabra,$_POST['id_tipo_palabra'],1);

header ("Location: editar_palabra.php?id=$id_palabra&mensaje=Palabra modificada");

?>