<?php
session_start();
 
include ('../../classes/querys/query.php');

$query=new query();

if ($_POST['definicion'] != "") { 

$palabra=$_POST['palabra'];
$definicion=$_POST['definicion'];

$datos_palabra=$query->add_palabra($_POST['PickList'],$palabra,utf8_decode($definicion),$_POST['id_tipo_palabra'],$_SESSION['ID_USER'],1);

echo utf8_encode("Palabra añadida");
} else {
echo "Introduzca una definición";
}




?>