<?php 
session_start();
include ('../../classes/querys/query.php');
$query=new query();

$permisos=$query->permisos_usuario($_SESSION['ID_USER']);

include ("busquedas.php");
?>
