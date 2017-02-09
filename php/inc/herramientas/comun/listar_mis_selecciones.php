<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
$query=new query();

$opcion=$_POST['id'];
$id_usuario=$_SESSION['ID_USER'];

if ($opcion==2) {

	$mis_selecciones=$query->listar_mis_selecciones($id_usuario);
	
	echo '<select name="mi_seleccion" id="mi_seleccion">';
	
	while ($row=mysql_fetch_array($mis_selecciones)) {
	
		echo '<option value="'.$row['id_seleccion'].'">'.$row['seleccion'].'</option>';
	
	}

	echo '</select>';
}

?>
