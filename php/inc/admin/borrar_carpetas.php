<?php 
include ('../../classes/querys/query.php');
require('../../funciones/funciones.php');
require_once('../../classes/crypt/5CR.php');
require_once('../../configuration/key.inc');

$borrar_carpeta_fuente=rmdir_recurse('../../repositorio/simbolos/fuente/');
$borrar_carpeta_pendientes=rmdir_recurse('../../repositorio/simbolos/pendientes/');
?>
