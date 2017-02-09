<?php 
include ('../../classes/querys/query.php');

$query=new query();

$datos_palabra=$query->actualizar_definicion($_POST['id_palabra'],utf8_decode($_POST['definicion']));


echo $_POST['definicion'];
?>


