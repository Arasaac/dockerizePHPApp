<?php 
include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave
$query=new query();

$inicial=0;
$cantidad=1000000000;

$resultados=$query->listar_simbolos_provisionales_limit($inicial,$cantidad);
while ($row=mysql_fetch_array($resultados)) {

	$extension=explode('.',$row['archivo_temporal']);
	
	if ($extension[1]=='pn') { 
	$nombre_tmp=$extension[0].'.png';
	echo $nombre_tmp.'<br />';
	}
	$arreglar=$query->actualizar_simbolos_temporales($row['id_simbolo_tmp'],$nombre_tmp);

} //Cierro el While que recorre los simbolos provisionales pendientes de revisar
?>
