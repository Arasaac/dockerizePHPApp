<?php
session_start();
include ('../classes/querys/query.php');
$query=new query();

$id_tipo_palabra=3;

$result_palabras=$query->listar_palabras_tipo($id_tipo_palabra);

while ($row=mysql_fetch_array($result_palabras)) {
	
	$id_tema=2;
	$id_subtema=7;
	$procesar=$query->asignar_palabra_subtema_tmp($row['id_palabra'],$id_tema,$id_subtema);

}
?>