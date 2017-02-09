<?php 
session_start();

include ('../../../classes/querys/query.php');
require('../../../funciones/funciones.php');
$query=new query();

$opcion=$_POST['id'];
$id_usuario=$_SESSION['ID_USER'];

if ($opcion==2) {

	$plantillas=$query->listar_plantillas_paneles();
	
	echo '<select name="mi_seleccion" id="mi_seleccion" onChange="procesar(\'mostrar_panel_plantilla.php\',\'id=\'+document.generador_paneles.mi_seleccion.value+\'\',\'b1\'); procesar(\'mostrar_opciones_plantilla.php\',\'id=\'+document.generador_paneles.mi_seleccion.value+\'\',\'opciones\'); procesar(\'mostrar_opciones_celda.php\',\'id=\'+document.generador_paneles.mi_seleccion.value+\'\',\'opciones_celda\');">';
	echo '<option value="0">Seleccionar</option>';
	
	while ($row=mysql_fetch_array($plantillas)) {
	
		echo '<option value="'.$row['id_plantilla'].'">'.$row['plantilla'].'</option>';
	
	}

	echo '</select>';
}

?>
