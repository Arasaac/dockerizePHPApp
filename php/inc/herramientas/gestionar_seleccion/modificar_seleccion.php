<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
require_once('../../../classes/crypt/5CR.php');
require_once('../../../configuration/key.inc');

$encript = new E5CR($llave); //definimos un nuevo elemento y pasamos la llave

$id_usuario=$_POST['id_usuario'];
$nombre=$_POST['nombre_seleccion'];
$tags=$_POST['tags'];
$id_seleccion=$_POST['id_seleccion'];

$query=new query();

$seleccion=$query->modificar_seleccion($id_seleccion,$id_usuario,$nombre,$tags);

$orden=1;

foreach ($_POST['thelist2'] as $indice=>$valor){ 

	$row=$query->datos_archivo_repositorio($valor);
	$query->add_simbolos_seleccion($id_seleccion,$orden,$valor,$row['id_palabra']);
	$orden++;

} 
echo utf8_encode("Selección modificada");
?>