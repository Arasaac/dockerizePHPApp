<?php 
session_start();

include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

unset($_SESSION['mi_seleccion']);

foreach ($_POST['thelist2'] as $indice=>$valor){ 

	$encript->desencriptar($valor,1); //pasamos los datos a desencriptar y definimos el total //de variables incluidas en el paquete
	$ruta='ruta_cesto='.$valor['ruta_cesto'];
	$encript->encriptar($ruta,1); 
	$_SESSION['mi_seleccion'][$ruta] = 1;

} 

?>