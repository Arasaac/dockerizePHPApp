<?php 
include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$query=new query();

$inicial=0;
$cantidad=100000;

$resultados=$query->listar_simbolos_provisionales_limit($inicial,$cantidad);
while ($row=mysql_fetch_array($resultados)) {

	$validacion=$query->validar_simbolos_temporales($row['id_simbolo_tmp'],1);

} //Cierro el While que recorre los simbolos provisionales pendientes de revisar
?>
